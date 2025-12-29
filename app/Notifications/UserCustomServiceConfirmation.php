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
        
        $mail = (new MailMessage)
            ->subject('Custom Service Request Received - ' . config('app.name'))
            ->greeting('Hello ' . $userName . ',')
            ->line('Thank you for submitting your custom service request! We have received your details and will review them shortly.')
            ->line('**Request Summary:**')
            ->line('**Service:** ' . ($r['service'] ?? 'Custom Service'));

        // Add custom service details if available
        if (!empty($r['service_category'])) {
            $mail->line('**Category:** ' . ucwords(str_replace(['_', '-'], ' ', $r['service_category'])));
        }
        if (!empty($r['braid_size'])) {
            $mail->line('**Braid/Twist Size:** ' . ucwords(str_replace(['_', '-'], ' ', $r['braid_size'])));
        }
        if (!empty($r['hair_length'])) {
            $mail->line('**Hair Length:** ' . ucwords(str_replace(['_', '-'], ' ', $r['hair_length'])));
        }
        if (!empty($r['budget_range'])) {
            $budgetDisplay = str_replace(['_', '-'], [' ', ' - '], $r['budget_range']);
            $mail->line('**Budget Range:** ' . ucwords($budgetDisplay));
        }
        if (!empty($r['urgency'])) {
            $urgencyDisplay = str_replace(['_', '-'], ' ', $r['urgency']);
            $mail->line('**Timeline:** ' . ucwords($urgencyDisplay));
        }
        if (!empty($r['style_preferences'])) {
            $preferences = is_string($r['style_preferences']) ? json_decode($r['style_preferences'], true) : ($r['style_preferences_array'] ?? []);
            if (is_array($preferences) && !empty($preferences)) {
                $preferencesDisplay = array_map(function($p) {
                    return ucwords(str_replace(['_', '-'], ' ', $p));
                }, $preferences);
                $mail->line('**Style Preferences:** ' . implode(', ', $preferencesDisplay));
            }
        }

        $mail->line('**Preferred Date:** ' . ($r['appointment_date'] ?? 'Not specified'))
            ->line('**Preferred Time:** ' . ($r['appointment_time'] ?? 'Not specified'));

        if (!empty($r['special_requirements'])) {
            $mail->line('**Special Requirements:** ' . $r['special_requirements']);
        }
        if (!empty($r['message'])) {
            $mail->line('**Your Message:** ' . $r['message']);
        }

        return $mail
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
