<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class RescheduleRequestNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Booking $booking,
        protected ?string $preferredDate,
        protected ?string $preferredTime,
        protected ?string $note
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reschedule request for booking #'.$this->booking->id)
            ->view('emails.reschedule_request_admin', [
                'booking' => $this->booking,
                'preferredDate' => $this->preferredDate,
                'preferredTime' => $this->preferredTime,
                'note' => $this->note,
            ]);
    }
}
