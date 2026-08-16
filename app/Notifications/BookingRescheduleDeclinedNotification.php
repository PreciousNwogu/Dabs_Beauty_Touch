<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingRescheduleDeclinedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Booking $booking,
        protected string $requestedLabel,
        protected ?string $note = null
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your reschedule request — Dab\'s Beauty Touch')
            ->view('emails.reschedule_request_declined', [
                'booking' => $this->booking,
                'requestedLabel' => $this->requestedLabel,
                'note' => $this->note,
            ]);
    }
}
