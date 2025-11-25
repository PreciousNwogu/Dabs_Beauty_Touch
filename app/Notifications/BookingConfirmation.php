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
        $b = $this->booking;

        // Prefer persisted fields if available (safer for audit/consistency)
        $basePrice = $b->base_price ?? null;
        $adjust = $b->length_adjustment ?? null;

        // If persisted basePrice missing, try service lookup
        if (is_null($basePrice)) {
            try {
                $serviceModel = \App\Models\Service::where('slug', $b->service)->orWhere('name', $b->service)->first();
                if ($serviceModel) {
                    $basePrice = (float) $serviceModel->base_price;
                }
            } catch (\Exception $e) {
                $serviceModel = null;
            }
        }

        // If persisted adjustment missing, compute using two-step rule
        if (is_null($adjust) && $b->length) {
            $ordered = ['neck','shoulder','armpit','bra_strap','mid_back','waist','hip','tailbone','classic'];
            $midIndex = array_search('mid_back', $ordered, true);
            $idx = array_search($b->length, $ordered, true);
            if ($idx !== false && $midIndex !== false) {
                $d = $idx - $midIndex;
                // Per-step rule: each single step away from mid_back changes price by $20
                $adjust = ($d * 20.00);
            }
        }

        // Use a styled blade view for confirmation emails so we can show base/adjustment/total
        $subject = __('emails.confirmation.subject') ?: 'Booking Confirmation';

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.booking_confirmation', [
                'booking' => $b,
                'basePrice' => $basePrice,
                'adjust' => $adjust
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
