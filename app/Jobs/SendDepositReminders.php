<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Models\Booking;
use App\Notifications\DepositReminderNotification;

class SendDepositReminders
{
    public function handle(): int
    {
        $sent = 0;
        $cutoff = now()->subHours(2);
        $oldest = now()->subDays(14);

        $bookings = Booking::query()
            ->where('status', 'pending')
            ->where(function ($q) {
                $q->whereNull('payment_status')->orWhere('payment_status', 'pending');
            })
            ->whereNull('deposit_reminder_sent_at')
            ->where('created_at', '<=', $cutoff)
            ->where('created_at', '>=', $oldest)
            ->get()
            ->filter(fn (Booking $booking) => $this->shouldRemind($booking));

        foreach ($bookings as $booking) {
            try {
                Notification::route('mail', $booking->email)
                    ->notifyNow(new DepositReminderNotification($booking));

                $booking->deposit_reminder_sent_at = now();
                $booking->save();
                $sent++;

                Log::info('Deposit reminder sent', [
                    'booking_id' => $booking->id,
                    'email' => $booking->email,
                ]);
            } catch (\Throwable $e) {
                Log::warning('Deposit reminder failed', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $sent;
    }

    private function shouldRemind(Booking $booking): bool
    {
        if (! $booking->hasUsableEmail() || ! $booking->depositIsPending()) {
            return false;
        }

        $start = $this->appointmentAtInToronto($booking);
        if ($start && $start->lte(now('America/Toronto'))) {
            return false;
        }

        return true;
    }

    private function appointmentAtInToronto(Booking $booking): ?\Carbon\Carbon
    {
        if (! $booking->appointment_date) {
            return null;
        }

        try {
            $date = $booking->appointment_date instanceof \Carbon\Carbon
                ? $booking->appointment_date->format('Y-m-d')
                : \Carbon\Carbon::parse($booking->appointment_date)->format('Y-m-d');
            $time = $booking->appointment_time
                ? \Carbon\Carbon::parse($booking->appointment_time)->format('H:i')
                : '23:59';

            return \Carbon\Carbon::createFromFormat('Y-m-d H:i', $date.' '.$time, 'America/Toronto');
        } catch (\Throwable $e) {
            return null;
        }
    }
}
