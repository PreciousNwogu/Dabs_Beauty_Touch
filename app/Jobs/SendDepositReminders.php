<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Models\Booking;
use App\Notifications\DepositReminderNotification;

class SendDepositReminders
{
    public function handle(): int
    {
        $sent = 0;
        $cutoff = Carbon::now()->subHours(2);

        $bookings = Booking::query()
            ->where('status', 'pending')
            ->where(function ($q) {
                $q->whereNull('payment_status')->orWhere('payment_status', 'pending');
            })
            ->whereNull('deposit_reminder_sent_at')
            ->where('created_at', '<=', $cutoff)
            ->whereDate('appointment_date', '>=', now()->toDateString())
            ->get();

        foreach ($bookings as $booking) {
            if (! $booking->hasUsableEmail()) {
                continue;
            }

            try {
                Notification::route('mail', $booking->email)
                    ->notify(new DepositReminderNotification($booking));
                $booking->deposit_reminder_sent_at = now();
                $booking->save();
                $sent++;
            } catch (\Throwable $e) {
                Log::warning('Deposit reminder failed', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $sent;
    }
}
