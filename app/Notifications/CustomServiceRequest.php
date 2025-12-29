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
            // Admin notification with enhanced details
            $mail = (new MailMessage)
                ->subject('New Custom Service Request - ' . config('app.name'))
                ->greeting('New Custom Service Request')
                ->line('A customer has submitted a custom service request with detailed information:')
                ->line('**Name:** ' . ($r['name'] ?? 'N/A'))
                ->line('**Email:** ' . ($r['email'] ?? 'No email provided'))
                ->line('**Phone:** ' . ($r['phone'] ?? 'N/A'))
                ->line('**Requested Service:** ' . ($r['service'] ?? 'Custom Service'))
                ->line('**Preferred Date:** ' . ($r['appointment_date'] ?? 'Not specified'))
                ->line('**Preferred Time:** ' . ($r['appointment_time'] ?? 'Not specified'));

            // Add custom service details if available
            if (!empty($r['service_category'])) {
                $mail->line('**Service Category:** ' . ucwords(str_replace(['_', '-'], ' ', $r['service_category'])));
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
                $mail->line('**Timeline/Urgency:** ' . ucwords($urgencyDisplay));
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
            if (!empty($r['special_requirements'])) {
                $mail->line('**Special Requirements:** ' . $r['special_requirements']);
            }
            if (!empty($r['reference_image'])) {
                $mail->line('**Reference Image:** ' . (asset('storage/' . $r['reference_image'])));
            }
            if (!empty($r['message'])) {
                $mail->line('**Additional Message:** ' . $r['message']);
            }

            return $mail
                ->line('**Request ID:** #' . ($r['id'] ?? 'N/A'))
                ->action('View Request', route('admin.bookings.show', ['id' => $r['id'] ?? '']))
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

