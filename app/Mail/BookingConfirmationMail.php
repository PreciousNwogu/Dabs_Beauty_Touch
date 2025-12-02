<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = __('emails.confirmation.subject') ?: 'Booking Confirmation';

        // Reuse the same blade view used by the Notification for visual parity
        return $this->subject($subject)
                    ->view('emails.booking_confirmation', [
                        'booking' => $this->booking,
                        'basePrice' => $this->booking->base_price ?? null,
                        'adjust' => $this->booking->length_adjustment ?? null,
                    ]);
    }
}
