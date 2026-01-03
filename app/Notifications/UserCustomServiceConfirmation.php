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

        // Extract user's name - ensure we use the name field, not service name
        $userName = $r['name'] ?? 'there';
        // Make sure we're not accidentally using service name
        if (empty($userName) || $userName === $r['service']) {
            $userName = 'there';
        }
        
        // Use custom styled email template
        return (new MailMessage)
            ->subject('Custom Service Request Received - ' . config('app.name'))
            ->view('emails.custom_service_confirmation', [
                'request' => $r,
            ]);
    }

    public function toArray($notifiable)
    {
        return $this->request;
    }
}
