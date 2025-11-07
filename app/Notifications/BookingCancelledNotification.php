<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingCancelledNotification extends Notification
{
    use Queueable;

    protected Booking $booking;
    protected ?string $cancelledBy;

    public function __construct(Booking $booking, ?string $cancelledBy = null)
    {
        $this->booking = $booking;
        $this->cancelledBy = $cancelledBy;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $b = $this->booking;

        return (new MailMessage)
            ->subject('Your appointment has been cancelled')
            ->greeting('Hello ' . ($b->name ?? 'Customer'))
            ->line('Your appointment scheduled for ' . ($b->appointment_date?->format('F j, Y') ?? '') . ' ' . ($b->appointment_time ?? '') . ' has been cancelled.')
            ->line('Cancelled by: ' . ($this->cancelledBy ?? 'System'))
            ->action('View bookings', url('/admin/bookings/' . $b->id))
            ->line('If you have questions or would like to reschedule, please contact us.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
