<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

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

        return (new MailMessage)
            ->subject('Your appointment has been rescheduled')
            ->greeting('Hello ' . ($b->name ?? 'Customer'))
            ->line('Your appointment has been rescheduled.')
            ->line('Previous: ' . ($old['date'] ?? 'N/A') . ' ' . ($old['time'] ?? ''))
            ->line('New: ' . ($new['date'] ?? $b->appointment_date?->format('F j, Y')) . ' ' . ($new['time'] ?? $b->appointment_time))
            ->action('View booking', url('/admin/bookings/' . $b->id))
            ->line('If you did not request this change, please contact us immediately.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
