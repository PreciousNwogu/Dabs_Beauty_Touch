<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingReminderNotification extends Notification
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
        $subject = "Reminder: Appointment in {$this->hoursBefore} hour" . ($this->hoursBefore > 1 ? 's' : '');

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello,')
            ->line('This is a reminder that an appointment is scheduled in ' . $this->hoursBefore . ' hour(s).')
            ->line('Booking ID: ' . ('BK' . str_pad($b->id, 6, '0', STR_PAD_LEFT)))
            ->line('Customer: ' . ($b->name ?? 'N/A') . ' — ' . ($b->phone ?? 'N/A'))
            ->line('Service: ' . ($b->service ?? 'N/A'))
            ->line('When: ' . ($b->appointment_date?->format('F j, Y') ?? '') . ' ' . ($b->appointment_time ?? ''))
            ->action('View in admin', route('admin.bookings.show', ['id' => $b->id]));
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
