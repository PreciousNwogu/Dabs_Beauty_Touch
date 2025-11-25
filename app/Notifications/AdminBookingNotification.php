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
            // Prefer persisted base price/adjustment if present
            $basePrice = $b->base_price ?? null;
            $adjust = $b->length_adjustment ?? null;

            // If basePrice missing, try lookup
            if (is_null($basePrice)) {
                try {
                    $serviceModel = \App\Models\Service::where('slug', $b->service)->orWhere('name', $b->service)->first();
                    if ($serviceModel) $basePrice = (float) $serviceModel->base_price;
                } catch (\Exception $e) {
                    $serviceModel = null;
                }
            }

            // If adjust missing, compute using per-step $20 rule
            if (is_null($adjust) && $b->length) {
                $ordered = ['neck','shoulder','armpit','bra_strap','mid_back','waist','hip','tailbone','classic'];
                $midIndex = array_search('mid_back', $ordered, true);
                $idx = array_search($b->length, $ordered, true);
                if ($idx !== false && $midIndex !== false) {
                    $d = $idx - $midIndex;
                    $adjust = ($d * 20.00);
                }
            }

            if (! is_null($basePrice)) {
                $mail->line('Base price: $' . number_format($basePrice, 2));
            }

            if (! is_null($adjust)) {
                $mail->line('Length adjustment: $' . number_format($adjust, 2));
            }

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
