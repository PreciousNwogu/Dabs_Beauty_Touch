<?php

namespace App\Console\Commands;

use App\Jobs\SendBookingReminders;
use Illuminate\Console\Command;

class SendBookingRemindersCommand extends Command
{
    protected $signature = 'bookings:send-reminders
                            {hours=24 : Hours before the appointment (24 or 1)}
                            {--booking= : Send for a specific booking ID}
                            {--force : Send even if a reminder was already marked sent}';

    protected $description = 'Send appointment reminder emails to clients and admin';

    public function handle(): int
    {
        $hours = (int) $this->argument('hours');
        if (!in_array($hours, [24, 1], true)) {
            $this->error('Hours must be 24 or 1.');
            return self::FAILURE;
        }

        $bookingId = $this->option('booking') ? (int) $this->option('booking') : null;
        $force = (bool) $this->option('force');

        $sent = (new SendBookingReminders($hours))->handle($bookingId, $force);

        $this->info("Sent {$sent} reminder(s) for the {$hours}-hour window.");

        return self::SUCCESS;
    }
}
