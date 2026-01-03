<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AdminContactNotification extends Notification
{
    use Queueable;

    protected $contactData;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $contactData)
    {
        $this->contactData = $contactData;
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
        $data = $this->contactData;
        
        $mail = (new MailMessage)
            ->subject('New Contact Form Submission - ' . config('app.name'))
            ->greeting('New Contact Form Message')
            ->line('You have received a new message from the contact form:')
            ->line('**Name:** ' . ($data['name'] ?? 'N/A'))
            ->line('**Email:** ' . ($data['email'] ?? 'N/A'))
            ->line('**Subject:** ' . ($data['subject'] ?? 'No subject'))
            ->line('**Message:**')
            ->line($data['message'] ?? 'No message provided');

        // Add timestamp with correct timezone (America/Toronto)
        // Always use America/Toronto timezone for display
        $timezone = 'America/Toronto';
        
        if (!empty($data['submitted_at_timestamp'])) {
            // Timestamp is Unix timestamp (always UTC), create in UTC then convert to target timezone
            $submittedAt = Carbon::createFromTimestamp($data['submitted_at_timestamp'], 'UTC')
                ->setTimezone($timezone)
                ->format('F j, Y \a\t g:i A');
        } elseif (!empty($data['submitted_at'])) {
            // Parse the datetime string
            // Since toDateTimeString() doesn't include timezone, we need to interpret it
            // If submitted_at_timezone is provided, use it; otherwise assume it was created in target timezone
            $sourceTimezone = $data['submitted_at_timezone'] ?? $timezone;
            try {
                // Parse the datetime string in the source timezone, then convert to display timezone
                $submittedAt = Carbon::parse($data['submitted_at'], $sourceTimezone)
                    ->setTimezone($timezone)
                    ->format('F j, Y \a\t g:i A');
            } catch (\Exception $e) {
                // Fallback if parsing fails
                $submittedAt = Carbon::now($timezone)->format('F j, Y \a\t g:i A');
            }
        } else {
            // Fallback to current time in correct timezone
            $submittedAt = Carbon::now($timezone)->format('F j, Y \a\t g:i A');
        }
        $mail->line('**Submitted:** ' . $submittedAt);

        // Add reply action
        if (!empty($data['email'])) {
            $mail->action('Reply to ' . ($data['name'] ?? 'Customer'), 'mailto:' . $data['email']);
        }

        return $mail
            ->line('Please respond to this inquiry as soon as possible.')
            ->salutation('Best regards, ' . config('app.name') . ' System');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'name' => $this->contactData['name'] ?? null,
            'email' => $this->contactData['email'] ?? null,
            'subject' => $this->contactData['subject'] ?? null,
            'message' => $this->contactData['message'] ?? null,
        ];
    }
}

