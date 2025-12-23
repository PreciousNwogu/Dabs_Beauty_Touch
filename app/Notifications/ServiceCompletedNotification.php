<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
use Illuminate\Support\HtmlString;

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
        // Use Ontario timezone (America/Toronto) for completed time display
        // This ensures completion emails show the correct local time for Ontario
        $tz = 'America/Toronto';
        $completedAt = null;
        if ($this->booking->completed_at) {
            try {
                // completed_at is cast to datetime on the model; use the Carbon instance
                $completedAt = $this->booking->completed_at->setTimezone($tz)->format('F j, Y g:i A');
            } catch (\Exception $e) {
                // fallback to parsing if something unexpected is stored
                try {
                    $completedAt = Carbon::parse($this->booking->completed_at)->setTimezone($tz)->format('F j, Y g:i A');
                } catch (\Exception $_) {
                    $completedAt = null;
                }
            }
        }

        // Get the correct final price and full breakdown - prefer breakdown calculation for accuracy
        $breakdown = null;
        $finalPrice = null;
        try {
            // Use centralized pricing breakdown when available (most accurate)
            $breakdown = $this->booking->getPricingBreakdown();
            $finalPrice = $breakdown['final_price'] ?? $breakdown['computed_total'] ?? null;
        } catch (\Throwable $e) {
            // Fallback if breakdown fails
        }

        // For kids bookings, prefer kb_final_price if available
        if (is_null($finalPrice) && !empty($this->booking->kb_final_price)) {
            $finalPrice = (float) $this->booking->kb_final_price;
        }

        // Fallback to final_price field
        if (is_null($finalPrice)) {
            $finalPrice = $this->booking->final_price ?? 0;
        }

        // Get formatted duration
        $duration = $this->booking->getFormattedDuration();

        return (new MailMessage)
            ->subject("Service Completed - Dabs Beauty Touch")
            ->view('emails.service_completed', [
                'booking' => $this->booking,
                'completedAt' => $completedAt,
                'duration' => $duration,
                'finalPrice' => $finalPrice,
                'breakdown' => $breakdown,
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
            'booking_id' => $this->booking->id,
            'service' => $this->booking->service,
            'completed_at' => $this->booking->completed_at,
            'final_price' => $this->booking->final_price,
        ];
    }
}
