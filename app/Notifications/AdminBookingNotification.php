<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class AdminBookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;
    protected $bookingId;
    protected $confirmationCode;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking, $bookingId, $confirmationCode)
    {
        $this->booking = $booking;
        $this->bookingId = $bookingId;
        $this->confirmationCode = $confirmationCode;
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
        $appointmentDate = $this->booking->appointment_date;
        $createdAt = $this->booking->created_at;
        
        // Handle both Carbon instances and string dates
        if (is_string($appointmentDate)) {
            $appointmentDate = \Carbon\Carbon::parse($appointmentDate);
        }
        if (is_string($createdAt)) {
            $createdAt = \Carbon\Carbon::parse($createdAt);
        }
        
        return (new MailMessage)
            ->subject('🔔 New Booking Alert - Dab\'s Beauty Touch')
            ->greeting('New Appointment Booking!')
            ->line('A new appointment has been booked and requires your attention.')
            ->line('')
            ->line('**Customer Details:**')
            ->line('• **Name:** ' . $this->booking->name)
            ->line('• **Email:** ' . $this->booking->email)
            ->line('• **Phone:** ' . $this->booking->phone)
            ->line('')
            ->line('**Booking Information:**')
            ->line('• **Booking ID:** ' . $this->bookingId)
            ->line('• **Confirmation Code:** ' . $this->confirmationCode)
            ->line('• **Service:** ' . $this->booking->service)
            ->line('• **Date:** ' . $appointmentDate->format('l, F j, Y'))
            ->line('• **Time:** ' . $this->booking->appointment_time)
            ->line('• **Status:** ' . ucfirst($this->booking->status))
            ->line('• **Created:** ' . $createdAt->format('M j, Y g:i A'))
            ->line('')
            ->line('**Required Actions:**')
            ->line('🔹 Contact customer to arrange $20 deposit payment')
            ->line('🔹 Confirm appointment once deposit is received')
            ->line('🔹 Update booking status in admin panel')
            ->line('🔹 Add any special notes or requirements')
            ->line('')
            ->action('View in Admin Panel', url('/admin/bookings/' . $this->bookingId))
            ->line('**Customer Message/Notes:**')
            ->line($this->booking->message ?? 'No additional message provided.')
            ->line('')
            ->line('Please reach out to the customer promptly to confirm their appointment.')
            ->salutation('Dab\'s Beauty Touch Admin System');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->bookingId,
            'confirmation_code' => $this->confirmationCode,
            'customer_name' => $this->booking->name,
            'customer_email' => $this->booking->email,
            'customer_phone' => $this->booking->phone,
            'service' => $this->booking->service,
            'appointment_date' => $this->booking->appointment_date,
            'appointment_time' => $this->booking->appointment_time,
            'status' => $this->booking->status,
            'created_at' => $this->booking->created_at,
        ];
    }
}