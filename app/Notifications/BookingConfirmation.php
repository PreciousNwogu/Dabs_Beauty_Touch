<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingConfirmation extends Notification
{
    use Queueable;

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
        return (new MailMessage)
            ->subject('Booking Confirmation')
            ->greeting('Hello ' . ($this->booking->name ?? 'Customer'))
            ->line('Thank you for your booking. Here are your booking details:')
            ->line('Booking ID: ' . ('BK' . str_pad($this->booking->id, 6, '0', STR_PAD_LEFT)))
            ->line('Confirmation code: ' . ($this->booking->confirmation_code ?? 'N/A'))
            ->line('Service: ' . ($this->booking->service ?? 'N/A'))
            ->line('Length: ' . ($this->booking->length ?? 'N/A'))
            ->line('Total price: $' . number_format($this->booking->final_price ?? 0, 2))
            ->action('View booking', url(route('bookings.confirm', ['id' => $this->booking->id, 'code' => $this->booking->confirmation_code], false)))
            ->line('We will contact you shortly.');
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
