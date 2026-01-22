<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingModifiedNotification extends Notification
{
    use Queueable;

    protected Booking $booking;
    protected array $before;
    protected array $after;

    public function __construct(Booking $booking, array $before = [], array $after = [])
    {
        $this->booking = $booking;
        $this->before = $before;
        $this->after = $after;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $b = $this->booking;

        // Determine recipient email when possible so templates can adapt (admin vs customer)
        $recipientEmail = null;
        try {
            if (is_object($notifiable) && method_exists($notifiable, 'routeNotificationFor')) {
                $recipientEmail = $notifiable->routeNotificationFor('mail');
            } elseif (is_object($notifiable) && property_exists($notifiable, 'email')) {
                $recipientEmail = $notifiable->email;
            }
        } catch (\Throwable $e) {
            $recipientEmail = null;
        }

        $isRecipientOwner = false;
        if ($recipientEmail && !empty($b->email)) {
            try {
                $isRecipientOwner = (strtolower(trim($recipientEmail)) === strtolower(trim($b->email)));
            } catch (\Throwable $e) {
                $isRecipientOwner = false;
            }
        }

        $formattedId = 'BK' . str_pad($b->id ?? 0, 6, '0', STR_PAD_LEFT);
        $subject = $isRecipientOwner
            ? "Your booking was updated ({$formattedId})"
            : "Booking updated ({$formattedId})";

        $breakdown = [];
        try { $breakdown = $b->getPricingBreakdown(); } catch (\Throwable $e) { $breakdown = []; }

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.booking_modified', [
                'booking' => $b,
                'before' => $this->before,
                'after' => $this->after,
                'breakdown' => $breakdown,
                'recipient_email' => $recipientEmail,
                'is_recipient_owner' => $isRecipientOwner,
                'showContactInfo' => !$isRecipientOwner,
                'formattedId' => $formattedId,
            ]);
    }
}

