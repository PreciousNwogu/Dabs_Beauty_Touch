<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingConfirmation extends Notification implements ShouldQueue
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
        
        // Handle both Carbon instances and string dates
        if (is_string($appointmentDate)) {
            $appointmentDate = \Carbon\Carbon::parse($appointmentDate);
        }
        
        return (new MailMessage)
            ->subject('Booking Confirmation - Dab\'s Beauty Touch')
            ->greeting('Hello ' . $this->booking->name . '!')
            ->line('Thank you for booking an appointment with Dab\'s Beauty Touch.')
            ->line('**Booking Details:**')
            ->line('• **Booking ID:** ' . $this->bookingId)
            ->line('• **Confirmation Code:** ' . $this->confirmationCode)
            ->line('• **Service:** ' . $this->booking->service)
            ->line('• **Date:** ' . $appointmentDate->format('l, F j, Y'))
            ->line('• **Time:** ' . $this->booking->appointment_time)
            ->line('• **Phone:** ' . $this->booking->phone)
            ->line('')
            ->line('**Important Next Steps:**')
            ->line('📋 **Deposit Required:** Please contact us to arrange the $20 deposit payment to confirm your appointment.')
            ->line('📞 **Contact Information:**')
            ->line('• Phone: (123) 456-7890')
            ->line('• Email: info@dabsbeautytouch.com')
            ->line('')
            ->line('**Please Note:**')
            ->line('• Your appointment is not confirmed until the deposit is received')
            ->line('• We require a minimum 2-day cancellation notice')
            ->line('• Please arrive 10 minutes early for your appointment')
            ->line('')
            ->line('We look forward to serving you! If you have any questions, please don\'t hesitate to contact us.')
            ->salutation('Best regards,')
            ->salutation('The Dab\'s Beauty Touch Team');
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
            'service' => $this->booking->service,
            'appointment_date' => $this->booking->appointment_date,
            'appointment_time' => $this->booking->appointment_time,
        ];
    }
}