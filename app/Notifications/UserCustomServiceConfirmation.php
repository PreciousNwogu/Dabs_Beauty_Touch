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
            ->subject('We received your custom service request')
            ->greeting('Hello ' . ($r['name'] ?? 'there') . ',')
            ->line('Thanks for submitting a custom service request. We have received your details and will contact you shortly to confirm availability and pricing.')
            ->line('Requested service: ' . ($r['service'] ?? 'Custom'))
            ->line('Requested date: ' . ($r['appointment_date'] ?? 'N/A'))
            ->line('If any of this information is incorrect, please reply to this email or contact us directly.')
            ->salutation(config('app.name'));
    }

    public function toArray($notifiable)
    {
        return $this->request;
    }
}
