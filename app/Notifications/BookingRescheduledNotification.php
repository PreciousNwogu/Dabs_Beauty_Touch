<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;
use Carbon\Carbon;

class BookingRescheduledNotification extends Notification
{
    use Queueable;

    protected Booking $booking;
    protected array $meta;

    public function __construct(Booking $booking, array $meta = [])
    {
        $this->booking = $booking;
        $this->meta = $meta;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $b = $this->booking;
        $old = $this->meta['old'] ?? null;
        $new = $this->meta['new'] ?? null;
        // Format previous/new datetimes to use friendly AM/PM format when possible
        $tz = config('app.timezone') ?: 'UTC';
        $oldDisplay = ($old['date'] ?? 'N/A');
        if (!empty($old['date']) && !empty($old['time'])) {
            try {
                $o = Carbon::parse(($old['date'] . ' ' . $old['time']), $tz);
                $oldDisplay = $o->format('F j, Y g:i A');
            } catch (\Exception $e) {
                // fall back to raw values
                $oldDisplay = ($old['date'] ?? 'N/A') . ' ' . ($old['time'] ?? '');
            }
        }

        $newDisplay = ($new['date'] ?? $b->appointment_date?->format('F j, Y')) . ' ' . ($new['time'] ?? $b->appointment_time);
        if (!empty($new['date']) && !empty($new['time'])) {
            try {
                $n = Carbon::parse(($new['date'] . ' ' . $new['time']), $tz);
                $newDisplay = $n->format('F j, Y g:i A');
            } catch (\Exception $e) {
                $newDisplay = ($new['date'] ?? $b->appointment_date?->format('F j, Y')) . ' ' . ($new['time'] ?? $b->appointment_time);
            }
        }

        return (new MailMessage)
            ->subject('Your appointment has been rescheduled - Dabs Beauty Touch')
            ->view('emails.booking_rescheduled', [
                'booking' => $b,
                'old' => $old,
                'new' => $new,
                'oldDisplay' => $oldDisplay,
                'newDisplay' => $newDisplay,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
