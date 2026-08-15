<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('bookings:send-reminders 24')->everyTenMinutes()->withoutOverlapping();
Schedule::command('bookings:send-reminders 1')->everyFiveMinutes()->withoutOverlapping();
