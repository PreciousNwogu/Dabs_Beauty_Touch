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
        \App\Console\Commands\BackfillKidsSelectorFromNotes::class,
        \App\Console\Commands\SendBookingRemindersCommand::class,
        \App\Console\Commands\SendDepositRemindersCommand::class,
        \App\Console\Commands\PersistSiteImagesCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Client + admin reminders, 24 hours and 1 hour before confirmed appointments
        $schedule->command('bookings:send-reminders 24')->everyTenMinutes()->withoutOverlapping();
        $schedule->command('bookings:send-reminders 1')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('bookings:send-deposit-reminders')->everyFiveMinutes()->withoutOverlapping(10);
    }

    protected function commands()
    {
        // Load commands from routes/console.php if present
        if (file_exists(base_path('routes/console.php'))) {
            require base_path('routes/console.php');
        }
    }
}
