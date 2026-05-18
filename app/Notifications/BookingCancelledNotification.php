<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;

class BookingCancelledNotification extends Notification
{
    use Queueable;

    protected Booking $booking;
    protected ?string $cancelledBy;

    public function __construct(Booking $booking, ?string $cancelledBy = null)
    {
        $this->booking = $booking;
        $this->cancelledBy = $cancelledBy;
    }

    public function via(object $notifiable): array
    {
        // Only send cancellation emails to the booking owner (customer).
        try {
            $recipientEmail = null;
            if (is_object($notifiable) && method_exists($notifiable, 'routeNotificationFor')) {
                $recipientEmail = $notifiable->routeNotificationFor('mail');
            } elseif (is_object($notifiable) && property_exists($notifiable, 'email')) {
                $recipientEmail = $notifiable->email;
            }
            if ($recipientEmail && !empty($this->booking->email) && strtolower(trim($recipientEmail)) === strtolower(trim($this->booking->email))) {
                return ['mail'];
            }
            Log::info('BookingCancelledNotification: skipping non-owner recipient', ['booking_id' => $this->booking->id ?? null, 'recipient' => $recipientEmail]);
        } catch (\Throwable $e) {
            Log::warning('BookingCancelledNotification: failed to evaluate recipient in via()', ['error' => $e->getMessage()]);
        }

        return [];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $b = $this->booking;

        return (new MailMessage)
            ->subject(__('emails.cancelled.subject'))
            ->view('emails.booking_cancelled', ['booking' => $b, 'cancelledBy' => $this->cancelledBy]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
