<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Models\Booking;
use App\Notifications\BookingReminderNotification;
use App\Notifications\ClientBookingReminderNotification;

class SendBookingReminders
{
    protected int $hoursBefore;

    public function __construct(int $hoursBefore = 24)
    {
        $this->hoursBefore = $hoursBefore;
    }

    public function handle(?int $bookingId = null, bool $force = false): int
    {
        $sent = 0;
        $adminEmail = env('BOOKING_NOTIFICATION_EMAIL') ?: env('ADMIN_EMAIL') ?: config('mail.from.address');
        $bookings = $this->bookingsDue($bookingId, $force);

        foreach ($bookings as $booking) {
            try {
                if (!$force) {
                    if ($this->hoursBefore === 24 && $booking->reminder_24_sent) {
                        continue;
                    }
                    if ($this->hoursBefore === 1 && $booking->reminder_1_sent) {
                        continue;
                    }
                }

                $clientSent = $this->sendClientReminder($booking);
                $adminSent = $this->sendAdminReminder($booking, $adminEmail);

                if ($clientSent || $adminSent) {
                    if ($this->hoursBefore === 24) {
                        $booking->reminder_24_sent = true;
                    } elseif ($this->hoursBefore === 1) {
                        $booking->reminder_1_sent = true;
                    }
                    $booking->save();
                    $sent++;
                }
            } catch (\Throwable $e) {
                Log::error('Failed to send booking reminder', [
                    'booking_id' => $booking->id,
                    'hours_before' => $this->hoursBefore,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $sent;
    }

    private function bookingsDue(?int $bookingId, bool $force)
    {
        if ($bookingId) {
            $booking = Booking::find($bookingId);
            return $booking ? collect([$booking]) : collect();
        }

        $tz = 'America/Toronto';
        $target = Carbon::now($tz)->addHours($this->hoursBefore);
        $windowStart = $target->copy()->subMinutes(30);
        $windowEnd = $target->copy()->addMinutes(30);

        $query = Booking::where('status', 'confirmed')
            ->whereDate('appointment_date', '>=', $windowStart->toDateString())
            ->whereDate('appointment_date', '<=', $windowEnd->toDateString());

        if (!$force) {
            if ($this->hoursBefore === 24) {
                $query->where(function ($q) {
                    $q->where('reminder_24_sent', false)->orWhereNull('reminder_24_sent');
                });
            } elseif ($this->hoursBefore === 1) {
                $query->where(function ($q) {
                    $q->where('reminder_1_sent', false)->orWhereNull('reminder_1_sent');
                });
            }
        }

        return $query->get()->filter(function (Booking $booking) use ($windowStart, $windowEnd, $tz) {
            $when = $this->appointmentAt($booking, $tz);
            return $when && $when->between($windowStart, $windowEnd);
        });
    }

    private function appointmentAt(Booking $booking, string $tz): ?Carbon
    {
        if (!$booking->appointment_date || !$booking->appointment_time) {
            return null;
        }

        try {
            $date = Carbon::parse($booking->appointment_date)->format('Y-m-d');
            return Carbon::parse(trim($date . ' ' . $booking->appointment_time), $tz);
        } catch (\Throwable $e) {
            Log::warning('Could not parse appointment time for reminder', [
                'booking_id' => $booking->id,
                'date' => $booking->appointment_date,
                'time' => $booking->appointment_time,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    private function sendClientReminder(Booking $booking): bool
    {
        $email = trim((string) $booking->email);
        if ($email === '' || strtolower($email) === 'no-email@example.com') {
            return false;
        }

        try {
            Notification::route('mail', $email)
                ->notifyNow(new ClientBookingReminderNotification($booking, $this->hoursBefore));
            Log::info('Client booking reminder sent', [
                'booking_id' => $booking->id,
                'email' => $email,
                'hours_before' => $this->hoursBefore,
            ]);
            return true;
        } catch (\Throwable $e) {
            Log::error('Failed to send client booking reminder', [
                'booking_id' => $booking->id,
                'email' => $email,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    private function sendAdminReminder(Booking $booking, ?string $adminEmail): bool
    {
        if (!$adminEmail) {
            return false;
        }

        try {
            Notification::route('mail', $adminEmail)
                ->notifyNow(new BookingReminderNotification($booking, $this->hoursBefore));
            Log::info('Admin booking reminder sent', [
                'booking_id' => $booking->id,
                'email' => $adminEmail,
                'hours_before' => $this->hoursBefore,
            ]);
            return true;
        } catch (\Throwable $e) {
            Log::error('Failed to send admin booking reminder', [
                'booking_id' => $booking->id,
                'email' => $adminEmail,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
