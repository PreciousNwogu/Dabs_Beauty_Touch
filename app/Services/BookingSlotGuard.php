<?php

namespace App\Services;

use App\Exceptions\SlotUnavailableException;
use App\Models\Booking;
use App\Support\ServiceDuration;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Cache;

class BookingSlotGuard
{
    public const MAX_PER_DAY = 2;

    public const BLOCK_HOURS = 4;

    public function reserve(string $date, string $time, callable $create, ?int $ignoreBookingId = null, ?float $durationHours = null): mixed
    {
        $date = $this->normalizeDate($date);

        try {
            return Cache::lock('booking-slot:'.$date, 15)->block(10, function () use ($date, $time, $create, $ignoreBookingId, $durationHours) {
                $this->assertAvailable($date, $time, $ignoreBookingId, $durationHours);

                return $create();
            });
        } catch (LockTimeoutException $e) {
            throw new SlotUnavailableException('That time is being booked by someone else. Please try again.');
        }
    }

    public function assertAvailable(string $date, string $time, ?int $ignoreBookingId = null, ?float $durationHours = null): void
    {
        $date = $this->normalizeDate($date);
        $time = $this->normalizeTime($date, $time);
        $tz = config('app.timezone') ?: 'UTC';
        $durationHours = ServiceDuration::normalizeHours($durationHours ?? self::BLOCK_HOURS);
        $slotStart = Carbon::createFromFormat('Y-m-d H:i', $date.' '.$time, $tz);
        $slotEnd = $slotStart->copy()->addMinutes(ServiceDuration::toMinutes($durationHours));

        if ($slotStart->lte(Carbon::now($tz))) {
            throw new SlotUnavailableException('That time is no longer available. Please choose a later time.');
        }

        if (! in_array($time, $this->defaultSlotsForDate($slotStart), true)) {
            throw new SlotUnavailableException('Please choose an available appointment time.');
        }

        $existing = Booking::query()
            ->whereDate('appointment_date', $date)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->when($ignoreBookingId, fn ($q) => $q->where('id', '!=', $ignoreBookingId))
            ->get(['id', 'appointment_time', 'service_duration_minutes', 'service']);

        if ($existing->count() >= self::MAX_PER_DAY) {
            throw new SlotUnavailableException('This date is fully booked (maximum 2 appointments per day). Please choose another date.');
        }

        foreach ($existing as $booking) {
            try {
                $existingStart = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $date.' '.Carbon::parse($booking->appointment_time)->format('H:i'),
                    $tz
                );
            } catch (\Throwable $e) {
                continue;
            }

            $existingEnd = $existingStart->copy()->addMinutes(ServiceDuration::minutesForBooking($booking));

            if ($slotStart->lt($existingEnd) && $slotEnd->gt($existingStart)) {
                throw new SlotUnavailableException('That time overlaps another appointment. Please choose a different time.');
            }
        }
    }

    private function normalizeDate(string $date): string
    {
        return Carbon::parse($date)->toDateString();
    }

    private function normalizeTime(string $date, string $time): string
    {
        return Carbon::parse($date.' '.$time)->format('H:i');
    }

    /**
     * @return list<string>
     */
    private function defaultSlotsForDate(Carbon $date): array
    {
        $dayOfWeek = $date->dayOfWeek;

        if ($dayOfWeek === 0) {
            return ['13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'];
        }

        if ($dayOfWeek === 6) {
            return ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'];
        }

        return ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'];
    }
}
