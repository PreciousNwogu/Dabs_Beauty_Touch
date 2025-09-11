<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Models\Booking;
use App\Notifications\BookingConfirmation;

class SendTestMail extends Command
{
    protected $signature = 'mail:test {email?}';
    protected $description = 'Send a test booking confirmation email to the provided address (or mailtrap)';

    public function handle()
    {
        $email = $this->argument('email') ?? config('mail.from.address');

        // Create a temporary Booking object (not persisted)
        $booking = new Booking([
            'id' => 999999,
            'name' => 'Test User',
            'email' => $email,
            'phone' => '0000000000',
            'service' => 'Jumbo Knotless Braids',
            'length' => 'neck',
            'final_price' => 40.00,
            'confirmation_code' => 'CONFTEST'
        ]);

        // Send notification via mail
        $this->info('Sending test booking confirmation to: ' . $email);
        try {
            // Use the existing BookingConfirmation notification
            Notification::route('mail', $email)->notify(new BookingConfirmation($booking));
            $this->info('Mail queued/sent (check Mailtrap or configured mail driver)');
        } catch (\Exception $e) {
            $this->error('Failed to send mail: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
