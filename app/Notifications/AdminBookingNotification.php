<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class AdminBookingNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected Booking $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $b = $this->booking;
        $formattedId = 'BK' . str_pad($b->id, 6, '0', STR_PAD_LEFT);

        $subject = "New Booking received: {$formattedId}";

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.admin_booking_notification', [
                'booking' => $b,
                'formattedId' => $formattedId,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
