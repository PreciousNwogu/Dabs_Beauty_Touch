<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;
use App\Support\InteracDeposit;

class DepositReminderNotification extends Notification
{
    use Queueable;

    public function __construct(protected Booking $booking)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reminder: '.InteracDeposit::amountLabel().' deposit to hold your appointment')
            ->view('emails.deposit_reminder', [
                'booking' => $this->booking,
                'interacEmail' => InteracDeposit::email(),
                'amountLabel' => InteracDeposit::amountLabel(),
            ]);
    }
}
