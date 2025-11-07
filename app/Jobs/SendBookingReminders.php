<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Models\Booking;
use App\Notifications\BookingReminderNotification;

class SendBookingReminders implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected int $hoursBefore;

    public function __construct(int $hoursBefore = 24)
    {
        $this->hoursBefore = $hoursBefore;
        $this->queue = 'default';
    }

    public function handle(): void
    {
        $target = now()->addHours($this->hoursBefore);
        $windowStart = $target->copy()->subMinutes(30);
        $windowEnd = $target->copy()->addMinutes(30);

        // Find confirmed bookings scheduled within the window
        $bookings = Booking::where('status', 'confirmed')
            ->whereRaw("STR_TO_DATE(CONCAT(appointment_date, ' ', appointment_time), '%Y-%m-%d %H:%i') BETWEEN ? AND ?", [$windowStart->format('Y-m-d H:i:s'), $windowEnd->format('Y-m-d H:i:s')])
            ->get();

        $adminEmail = config('mail.admin_address') ?: env('ADMIN_EMAIL');

        foreach ($bookings as $booking) {
            try {
                // Check and mark flags to avoid duplicates
                if ($this->hoursBefore === 24 && $booking->reminder_24_sent) {
                    continue;
                }
                if ($this->hoursBefore === 1 && $booking->reminder_1_sent) {
                    continue;
                }

                if ($adminEmail) {
                    Notification::route('mail', $adminEmail)
                        ->notify(new BookingReminderNotification($booking, $this->hoursBefore));
                }

                // mark sent
                if ($this->hoursBefore === 24) {
                    $booking->reminder_24_sent = true;
                } else {
                    $booking->reminder_1_sent = true;
                }
                $booking->save();
            } catch (\Throwable $e) {
                Log::error('Failed to send booking reminder', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            }
        }
    }
}
