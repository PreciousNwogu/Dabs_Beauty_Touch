<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCustomServiceConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request;

    public function __construct(array $request)
    {
        $this->request = $request;
        $this->onQueue('mail');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $r = $this->request;

        return (new MailMessage)
            ->subject('Custom Service Request Received - ' . config('app.name'))
            ->greeting('Hello ' . ($r['name'] ?? 'there') . ',')
            ->line('Thank you for submitting your custom service request! We have received your details and will review them shortly.')
            ->line('**Request Summary:**')
            ->line('**Service:** ' . ($r['service'] ?? 'Custom Service'))
            ->line('**Preferred Date:** ' . ($r['appointment_date'] ?? 'Not specified'))
            ->line('**Preferred Time:** ' . ($r['appointment_time'] ?? 'Not specified'))
            ->when(!empty($r['message']), function ($mail) use ($r) {
                return $mail->line('**Your Message:** ' . $r['message']);
            })
            ->line('**What happens next?**')
            ->line('Our team will review your request and contact you within 24-48 hours to:')
            ->line('• Confirm service availability')
            ->line('• Provide detailed pricing information')
            ->line('• Schedule your appointment')
            ->line('If you have any questions or need to update your request, please reply to this email or contact us directly.')
            ->action('Contact Us', url('/#contact'))
            ->salutation('Best regards, ' . config('app.name') . ' Team');
    }

    public function toArray($notifiable)
    {
        return $this->request;
    }
}
