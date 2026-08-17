<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\SlotUnavailableException;
use App\Http\Controllers\Controller;
use App\Mail\BookingRescheduleDeclinedMail;
use App\Models\Booking;
use App\Models\Schedule;
use App\Notifications\BookingRescheduledNotification;
use App\Support\ServiceDuration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class BookingRescheduleRequestController extends Controller
{
    public function approve(int $id)
    {
        $booking = Booking::findOrFail($id);
        if (! $booking->hasPendingRescheduleRequest()) {
            return back()->with('error', 'There is no waiting reschedule request on this booking.');
        }

        $date = $booking->reschedule_requested_date instanceof Carbon
            ? $booking->reschedule_requested_date->toDateString()
            : Carbon::parse($booking->reschedule_requested_date)->toDateString();
        $time = Carbon::parse($booking->reschedule_requested_time)->format('H:i');

        try {
            $this->assertSlotOpen($booking, $date, $time);
        } catch (SlotUnavailableException $e) {
            return back()->with('error', $e->getMessage().' Leave this request waiting, then use Reschedule to pick another time.');
        }

        $oldTimeFormatted = $booking->appointment_time;
        try {
            if ($booking->appointment_date && $booking->appointment_time) {
                $oldTimeFormatted = Carbon::parse($booking->appointment_date->format('Y-m-d').' '.$booking->appointment_time)->format('g:i A');
            }
        } catch (\Throwable $e) {
        }

        $old = [
            'date' => $booking->appointment_date ? $booking->appointment_date->format('F j, Y') : null,
            'time' => $oldTimeFormatted,
        ];

        $booking->appointment_date = $date;
        $booking->appointment_time = $time;
        $booking->reschedule_request_status = 'approved';
        $booking->notes = trim(($booking->notes ?? '')."\nReschedule approved: ".$date.' '.$time);
        $booking->save();

        $new = [
            'date' => Carbon::parse($date)->format('F j, Y'),
            'time' => $time,
        ];

        try {
            if ($booking->hasUsableEmail()) {
                Notification::route('mail', $booking->email)
                    ->notify(new BookingRescheduledNotification($booking, ['old' => $old, 'new' => $new]));
            }
        } catch (\Throwable $e) {
            Log::warning('Approved reschedule email failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
        }

        return back()->with('success', 'New time approved. The client was emailed.');
    }

    public function decline(Request $request, int $id)
    {
        $booking = Booking::findOrFail($id);
        if (! $booking->hasPendingRescheduleRequest()) {
            return back()->with('error', 'There is no waiting reschedule request on this booking.');
        }

        $data = $request->validate([
            'decline_note' => 'nullable|string|max:1000',
        ]);
        $note = trim((string) ($data['decline_note'] ?? ''));

        $requested = $booking->requestedRescheduleLabel();
        $booking->reschedule_request_status = 'declined';
        $booking->notes = trim(($booking->notes ?? '')."\nReschedule declined".($note !== '' ? ': '.$note : '').'. Original time kept.');
        $booking->save();

        $emailed = $this->emailDeclinedReschedule($booking, $requested, $note !== '' ? $note : null);

        return back()->with(
            $emailed ? 'success' : 'error',
            $emailed
                ? 'Request declined. The original time is still booked. The client was emailed.'
                : 'Request declined and the original time is still booked, but the client email did not send. Reply to them from your inbox.'
        );
    }

    private function emailDeclinedReschedule(Booking $booking, string $requested, ?string $note): bool
    {
        $addresses = collect([$booking->email, $booking->user?->email])
            ->map(fn ($email) => strtolower(trim((string) $email)))
            ->filter(fn ($email) => $email !== ''
                && $email !== 'no-email@example.com'
                && filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values();

        if ($addresses->isEmpty()) {
            Log::warning('Declined reschedule email skipped: no usable client email', ['booking_id' => $booking->id]);

            return false;
        }

        try {
            Mail::to($addresses->all())->send(new BookingRescheduleDeclinedMail($booking, $requested, $note));
            Log::info('Declined reschedule email sent', [
                'booking_id' => $booking->id,
                'to' => $addresses->all(),
            ]);

            return true;
        } catch (\Throwable $e) {
            Log::error('Declined reschedule email failed', [
                'booking_id' => $booking->id,
                'to' => $addresses->all(),
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function assertSlotOpen(Booking $booking, string $date, string $time): void
    {
        $tz = config('app.timezone') ?: 'America/Toronto';
        $start = Carbon::createFromFormat('Y-m-d H:i', $date.' '.$time, $tz);
        $end = $start->copy()->addMinutes(ServiceDuration::minutesForBooking($booking));

        if ($start->lte(Carbon::now($tz))) {
            throw new SlotUnavailableException('That requested time is already in the past.');
        }

        $blocked = Schedule::where('type', 'blocked')
            ->where('start', '<', $end)
            ->where('end', '>', $start)
            ->exists();
        if ($blocked) {
            throw new SlotUnavailableException('That requested time falls on a closed date.');
        }

        $sameDay = Booking::query()
            ->whereDate('appointment_date', $date)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->where('id', '!=', $booking->id)
            ->get(['id', 'appointment_time', 'service_duration_minutes', 'service']);

        $max = \App\Support\SiteSettings::maxBookingsPerDay();
        if ($sameDay->count() >= $max) {
            throw new SlotUnavailableException('That day is already full.');
        }

        foreach ($sameDay as $other) {
            try {
                $otherStart = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $date.' '.Carbon::parse($other->appointment_time)->format('H:i'),
                    $tz
                );
            } catch (\Throwable $e) {
                continue;
            }
            $otherEnd = $otherStart->copy()->addMinutes(ServiceDuration::minutesForBooking($other));
            if ($start->lt($otherEnd) && $end->gt($otherStart)) {
                throw new SlotUnavailableException('That requested time overlaps another appointment.');
            }
        }
    }
}
