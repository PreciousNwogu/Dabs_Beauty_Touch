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

        $mail = (new MailMessage)
            ->subject("New Booking received: {$formattedId}")
            ->greeting('Hello Admin,')
            ->line("A new booking has been received.")
            ->line("Booking ID: {$formattedId}")
            ->line("Name: " . ($b->name ?? 'N/A'))
            ->line("Service: " . ($b->service ?? 'N/A'))
            ->line("Appointment: " . ($b->appointment_date?->format('F j, Y') ?? 'N/A') . ' ' . ($b->appointment_time ?? ''))
            ->line("Email: " . ($b->email ?? 'N/A'))
            ->line("Phone: " . ($b->phone ?? 'N/A'));

        if (! is_null($b->final_price)) {
            $mail->line('Final Price: $' . number_format($b->final_price, 2));
        }

        // Action: link to admin booking view if exists
        $adminUrl = url('/admin/bookings/' . $b->id);
        $mail->action('View Booking', $adminUrl)
            ->line('Thank you for using our application!');

        return $mail;
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
