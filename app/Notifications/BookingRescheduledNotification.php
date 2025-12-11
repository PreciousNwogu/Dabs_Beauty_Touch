<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;
use Carbon\Carbon;

class BookingRescheduledNotification extends Notification
{
    use Queueable;

    protected Booking $booking;
    protected array $meta;

    public function __construct(Booking $booking, array $meta = [])
    {
        $this->booking = $booking;
        $this->meta = $meta;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $b = $this->booking;
        $old = $this->meta['old'] ?? null;
        $new = $this->meta['new'] ?? null;
        // Format previous/new datetimes to use friendly AM/PM format when possible
        $tz = config('app.timezone') ?: 'UTC';
        $oldDisplay = ($old['date'] ?? 'N/A');
        if (!empty($old['date']) && !empty($old['time'])) {
            try {
                $o = Carbon::parse(($old['date'] . ' ' . $old['time']), $tz);
                $oldDisplay = $o->format('F j, Y g:i A');
            } catch (\Exception $e) {
                // fall back to raw values
                $oldDisplay = ($old['date'] ?? 'N/A') . ' ' . ($old['time'] ?? '');
            }
        }

        $newDisplay = ($new['date'] ?? $b->appointment_date?->format('F j, Y')) . ' ' . ($new['time'] ?? $b->appointment_time);
        if (!empty($new['date']) && !empty($new['time'])) {
            try {
                $n = Carbon::parse(($new['date'] . ' ' . $new['time']), $tz);
                $newDisplay = $n->format('F j, Y g:i A');
            } catch (\Exception $e) {
                $newDisplay = ($new['date'] ?? $b->appointment_date?->format('F j, Y')) . ' ' . ($new['time'] ?? $b->appointment_time);
            }
        }

        $mail = (new MailMessage)
            ->subject('Your appointment has been rescheduled')
            ->greeting('Hello ' . ($b->name ?? 'Customer'))
            ->line('Your appointment has been rescheduled.')
            ->line('Previous: ' . $oldDisplay)
            ->line('New: ' . $newDisplay)
            ->action('View booking', url('/admin/bookings/' . $b->id))
            ->line('If you did not request this change, please contact us immediately.');

        // When a new datetime is provided, offer an 'Add to Google Calendar' link
        try {
            if (!empty($new['date']) && !empty($new['time'])) {
                $start = Carbon::parse($new['date'] . ' ' . $new['time'], $tz)->toImmutable();
                $duration = (int) ($b->service_duration_minutes ?? 90);
                $end = $start->addMinutes($duration);
                $startU = $start->utc()->format('Ymd\THis\Z');
                $endU = $end->utc()->format('Ymd\THis\Z');
                $title = rawurlencode(($b->service ?? 'Appointment') . ' (' . ($b->confirmation_code ?? ('BK' . str_pad($b->id ?? 0, 6, '0', STR_PAD_LEFT))) . ')');
                $details = rawurlencode('Customer: ' . ($b->name ?? '') . '\nPhone: ' . ($b->phone ?? ''));
                $gcal = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' . $title . '&dates=' . $startU . '/' . $endU . '&details=' . $details;
                $mail->action('Add to Google Calendar', $gcal);
            }
        } catch (\Exception $e) { /* don't fail email for calendar link issues */ }

        return $mail;
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
