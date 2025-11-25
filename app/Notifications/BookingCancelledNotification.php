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
            ->subject(__('emails.cancelled.subject'))
            ->view('emails.booking_cancelled', ['booking' => $b, 'cancelledBy' => $this->cancelledBy]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
