<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class AdminCancellationNotice extends Notification
{
    use Queueable;

    public function __construct(protected Booking $booking, protected string $cancelledBy = 'Client')
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $b = $this->booking;
        $when = trim(($b->appointment_date?->format('F j, Y') ?? '').' '.($b->appointment_time ?? ''));

        return (new MailMessage)
            ->subject('Booking #'.$b->id.' cancelled by '.$this->cancelledBy)
            ->line($this->cancelledBy.' cancelled booking #'.$b->id.'.')
            ->line('Client: '.($b->name ?? 'N/A'))
            ->line('Service: '.($b->service ?? 'N/A'))
            ->line('When: '.($when !== '' ? $when : 'N/A'))
            ->action('Open booking', url('/admin/bookings/'.$b->id));
    }
}
