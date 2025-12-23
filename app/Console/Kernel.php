<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendTestMail::class,
        \App\Console\Commands\PreviewEmail::class,
        \App\Console\Commands\CancelBookingsRange::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Send admin booking reminders 24 hours and 1 hour before appointment
        $schedule->job(new \App\Jobs\SendBookingReminders(24))->everyTenMinutes();
        $schedule->job(new \App\Jobs\SendBookingReminders(1))->everyFiveMinutes();
    }

    protected function commands()
    {
        // Load commands from routes/console.php if present
        if (file_exists(base_path('routes/console.php'))) {
            require base_path('routes/console.php');
        }
    }
}
