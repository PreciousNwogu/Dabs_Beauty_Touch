<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class ClientBookingReminderNotification extends Notification
{
    use Queueable;

    protected Booking $booking;
    protected int $hoursBefore;

    public function __construct(Booking $booking, int $hoursBefore = 24)
    {
        $this->booking = $booking;
        $this->hoursBefore = $hoursBefore;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $b = $this->booking;
        $firstName = $this->firstName($b->name);
        $isSoon = $this->hoursBefore <= 2;

        $subject = $isSoon
            ? "We'll see you soon, {$firstName}"
            : "See you tomorrow, {$firstName}";

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.booking_reminder_client', [
                'booking' => $b,
                'hoursBefore' => $this->hoursBefore,
                'firstName' => $firstName,
                'isSoon' => $isSoon,
                'formattedDate' => $this->formattedDate($b),
                'formattedTime' => $this->formattedTime($b),
                'locationLabel' => $this->locationLabel($b),
                'isHomeService' => $b->appointment_type === 'mobile',
                'manageUrl' => $this->manageUrl($b),
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }

    private function firstName(?string $name): string
    {
        $name = trim((string) $name);
        if ($name === '') {
            return 'there';
        }

        return explode(' ', $name)[0];
    }

    private function formattedDate(Booking $b): string
    {
        if (!$b->appointment_date) {
            return 'TBD';
        }

        try {
            return Carbon::parse($b->appointment_date)->format('l, F j, Y');
        } catch (\Throwable $e) {
            return (string) $b->appointment_date;
        }
    }

    private function formattedTime(Booking $b): string
    {
        if (!$b->appointment_time) {
            return 'TBD';
        }

        try {
            return Carbon::parse($b->appointment_time)->format('g:i A');
        } catch (\Throwable $e) {
            return (string) $b->appointment_time;
        }
    }

    private function locationLabel(Booking $b): string
    {
        if ($b->appointment_type === 'mobile') {
            return $b->address ? 'Home service — ' . $b->address : 'Home service';
        }

        return 'Stylist location';
    }

    private function manageUrl(Booking $b): ?string
    {
        if (!$b->id || empty($b->confirmation_code)) {
            return null;
        }

        return url('/bookings/confirm/' . $b->id . '/' . $b->confirmation_code);
    }
}
