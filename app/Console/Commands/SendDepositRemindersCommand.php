<?php

namespace App\Console\Commands;

use App\Jobs\SendDepositReminders;
use Illuminate\Console\Command;

class SendDepositRemindersCommand extends Command
{
    protected $signature = 'bookings:send-deposit-reminders';

    protected $description = 'Remind clients who have not sent the Interac deposit';

    public function handle(): int
    {
        $sent = (new SendDepositReminders())->handle();
        $this->info("Sent {$sent} deposit reminder(s).");

        return self::SUCCESS;
    }
}
