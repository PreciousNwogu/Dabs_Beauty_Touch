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

        // Use centralized pricing breakdown so mailables and notifications match
        $break = [];
        try { $break = $this->booking->getPricingBreakdown(); } catch (\Throwable $e) { $break = []; }

        return $this->subject($subject)
                    ->view('emails.booking_confirmation', [
                        'booking' => $this->booking,
                        'basePrice' => $break['resolved_base'] ?? ($this->booking->base_price ?? null),
                        'length_adjust' => $break['length_adjust'] ?? ($this->booking->length_adjustment ?? 0),
                        'addons_total' => $break['addons_total'] ?? null,
                        'adjustments_total' => $break['adjustments_total'] ?? null,
                        'computedTotal' => $break['computed_total'] ?? null,
                        'final_price' => $break['final_price'] ?? ($this->booking->final_price ?? null),
                        'selector' => $break['selector'] ?? null,
                        'selector_friendly' => $break['selector_friendly'] ?? null,
                        'selector_base' => $break['selector_base'] ?? null,
                        'selector_adjust' => $break['selector_adjust'] ?? null,
                        'selector_addons' => $break['selector_addons'] ?? null,
                        'hideLengthFinish' => $break['hide_length_finish'] ?? false,
                    ]);
    }
}
