<?php
// tools/send_admin_notification.php
// Usage: php tools/send_admin_notification.php [--mailtrap] [--env-file=.env.mailtrap]
// Sends an AdminBookingNotification to the configured ADMIN_EMAIL (or BOOKING_NOTIFICATION_EMAIL).

require __DIR__ . '/../vendor/autoload.php';

function loadEnvFile(string $path)
{
    if (! file_exists($path)) {
        fwrite(STDERR, "Env file not found: {$path}\n");
        return false;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (! str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        $value = preg_replace('/^"(.*)"$/', '$1', $value);
        $value = preg_replace("/^'(.*)'$/", '$1', $value);
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }

    return true;
}

$rawArgs = $argv;
array_shift($rawArgs);
$envFile = null;
$bookingId = null;
foreach ($rawArgs as $arg) {
    if (str_starts_with($arg, '--env-file=')) {
        $envFile = substr($arg, strlen('--env-file='));
        continue;
    }
    if ($arg === '--mailtrap' || $arg === '--use-mailtrap') {
        $envFile = __DIR__ . '/../.env.mailtrap';
        continue;
    }
    // support passing id as positional arg
    if (! str_starts_with($arg, '--') && is_numeric($arg)) {
        $bookingId = (int) $arg;
    }
}

if ($envFile) loadEnvFile($envFile);

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Notification;
use App\Models\Booking;

// Debug: print effective MAIL_* values so developer can confirm which env is active
echo "Using MAIL_MAILER=" . (getenv('MAIL_MAILER') ?: 'null') . "\n";
echo "Using MAIL_HOST=" . (getenv('MAIL_HOST') ?: 'null') . "\n";
echo "Using MAIL_PORT=" . (getenv('MAIL_PORT') ?: 'null') . "\n";
echo "Using MAIL_USERNAME=" . (getenv('MAIL_USERNAME') ?: 'null') . "\n";

$admin = getenv('BOOKING_NOTIFICATION_EMAIL') ?: getenv('ADMIN_EMAIL') ?: config('mail.from.address');

if (! $admin) {
    echo "No admin email configured (ADMIN_EMAIL or BOOKING_NOTIFICATION_EMAIL).\n";
    exit(1);
}

echo "Sending AdminBookingNotification to: {$admin}\n";
try {
    // find booking to include details
    if ($bookingId) {
        $booking = Booking::find($bookingId);
    } else {
        $booking = Booking::latest()->first();
    }

    if (! $booking) {
        echo "No booking found to include in admin notification.\n";
        exit(1);
    }

    Notification::route('mail', $admin)->notify(new App\Notifications\AdminBookingNotification($booking));
    echo "Done — notification attempted.\n";
} catch (\Throwable $e) {
    echo "Failed to send admin notification: " . $e->getMessage() . "\n";
    exit(2);
}

exit(0);
