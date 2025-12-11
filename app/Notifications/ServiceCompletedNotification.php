<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class ServiceCompletedNotification extends Notification
{
    use Queueable;

    protected $booking;

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
        // Use application timezone for the completed time display
        $tz = config('app.timezone') ?: 'UTC';
        $completedAt = null;
        try {
            if ($this->booking->completed_at) {
                $completedAt = Carbon::parse($this->booking->completed_at)->setTimezone($tz)->format('F j, Y g:i A');
            }
        } catch (\Exception $e) { $completedAt = $this->booking->completed_at?->format('F j, Y g:i A'); }

        $mail = (new MailMessage)
                    ->subject("Service Completed - Dab's Beauty Touch")
                    ->greeting('Hello ' . ($this->booking->name ?? 'Customer') . '!')
                    ->line('Your beauty service has been completed successfully.')
                    ->line('Service: ' . ($this->booking->service ?? '—'))
                    ->line('Completed on: ' . ($completedAt ?? '—'))
                    ->line('Duration: ' . ($this->booking->getFormattedDuration() ?? '—'))
                    ->line('Final Price: $' . number_format($this->booking->final_price ?? 0, 2))
                    ->line('Thank you for choosing Dab\'s Beauty Touch!')
                    ->line('We hope you love your new look!')
                    ->action('Book Another Appointment', url('/'))
                    ->line('Follow us on social media for styling tips and latest trends.')
                    ->line('Instagram: https://www.instagram.com/dabs_beauty_touch')
                    ->line('WhatsApp: https://wa.me/13432548848');

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
            'booking_id' => $this->booking->id,
            'service' => $this->booking->service,
            'completed_at' => $this->booking->completed_at,
            'final_price' => $this->booking->final_price,
        ];
    }
}
