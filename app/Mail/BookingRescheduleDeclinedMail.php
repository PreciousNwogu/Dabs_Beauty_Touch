<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingRescheduleDeclinedMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public Booking $booking,
        public string $requestedLabel = '',
        public ?string $note = null
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your appointment time stays the same — Dab\'s Beauty Touch',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reschedule_request_declined',
            with: [
                'booking' => $this->booking,
                'requestedLabel' => $this->requestedLabel,
                'note' => $this->note,
            ],
        );
    }
}
