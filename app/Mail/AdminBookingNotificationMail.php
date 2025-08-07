<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminBookingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $bookingId;
    public $confirmationCode;

    public function __construct($booking, $bookingId, $confirmationCode)
    {
        $this->booking = $booking;
        $this->bookingId = $bookingId;
        $this->confirmationCode = $confirmationCode;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Booking Received - Dabs Beauty Touch',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-booking-notification',
            with: [
                'booking' => $this->booking,
                'bookingId' => $this->bookingId,
                'confirmationCode' => $this->confirmationCode,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
