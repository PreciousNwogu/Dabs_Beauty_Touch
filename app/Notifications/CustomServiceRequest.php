<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomServiceRequest extends Notification implements ShouldQueue
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
        $isAdmin = $r['is_admin'] ?? false;

        if ($isAdmin) {
            // Admin notification
            return (new MailMessage)
                ->subject('New Custom Service Request - ' . config('app.name'))
                ->greeting('New Custom Service Request')
                ->line('A customer has submitted a custom service request:')
                ->line('**Name:** ' . ($r['name'] ?? 'N/A'))
                ->line('**Email:** ' . ($r['email'] ?? 'No email provided'))
                ->line('**Phone:** ' . ($r['phone'] ?? 'N/A'))
                ->line('**Requested Service:** ' . ($r['service'] ?? 'Custom Service'))
                ->line('**Preferred Date:** ' . ($r['appointment_date'] ?? 'Not specified'))
                ->line('**Preferred Time:** ' . ($r['appointment_time'] ?? 'Not specified'))
                ->when(!empty($r['message']), function ($mail) use ($r) {
                    return $mail->line('**Message:** ' . $r['message']);
                })
                ->line('**Request ID:** #' . ($r['id'] ?? 'N/A'))
                ->action('View Request', url('/admin/custom-requests/' . ($r['id'] ?? '')))
                ->line('Please review and respond to this request as soon as possible.')
                ->salutation('Best regards, ' . config('app.name'));
        } else {
            // User notification (shouldn't normally be called with is_admin=false, but just in case)
            return (new MailMessage)
                ->subject('Custom Service Request Received - ' . config('app.name'))
                ->greeting('Hello ' . ($r['name'] ?? 'there') . ',')
                ->line('Thank you for your custom service request!')
                ->line('We have received your request and will review it shortly.')
                ->line('**Requested Service:** ' . ($r['service'] ?? 'Custom Service'))
                ->line('**Preferred Date:** ' . ($r['appointment_date'] ?? 'Not specified'))
                ->line('We will contact you soon to confirm availability and provide pricing details.')
                ->salutation('Best regards, ' . config('app.name'));
        }
    }

    public function toArray($notifiable)
    {
        return $this->request;
    }
}

