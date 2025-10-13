<?php
// tools/complete_booking.php
// Usage: php tools/complete_booking.php [booking_id]
// If booking_id is omitted, the latest booking will be used.

require __DIR__ . '/../vendor/autoload.php';

// Simple helper: allow loading an env file (or use --mailtrap) before bootstrapping
// so a one-off run can use Mailtrap without editing .env or clearing config cache.
function loadEnvFile(string $path)
{
    if (! file_exists($path)) {
        fwrite(STDERR, "Env file not found: {$path}\n");
        return false;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        if (! str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        // remove surrounding quotes
        $value = preg_replace('/^"(.*)"$/', '$1', $value);
        $value = preg_replace("/^'(.*)'$/", '$1', $value);
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }

    return true;
}

// parse CLI args: support --env-file=path and --mailtrap (alias for .env.mailtrap)
$rawArgs = $argv;
array_shift($rawArgs); // drop script name
$envFile = null;
$id = null;
foreach ($rawArgs as $arg) {
    if (str_starts_with($arg, '--env-file=')) {
        $envFile = substr($arg, strlen('--env-file='));
        continue;
    }
    if ($arg === '--mailtrap' || $arg === '--use-mailtrap') {
        $envFile = __DIR__ . '/../.env.mailtrap';
        continue;
    }
    // first non-flag argument is booking id
    if (! str_starts_with($arg, '--')) {
        $id = $arg;
        // don't break; allow flags after id
    }
}

if ($envFile) {
    loadEnvFile($envFile);
}

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;

// Debug: print the effective mail config seen by this process
echo "Using MAIL_MAILER=" . (getenv('MAIL_MAILER') ?: 'null') . "\n";
echo "Using MAIL_HOST=" . (getenv('MAIL_HOST') ?: 'null') . "\n";
echo "Using MAIL_PORT=" . (getenv('MAIL_PORT') ?: 'null') . "\n";
echo "Using MAIL_USERNAME=" . (getenv('MAIL_USERNAME') ?: 'null') . "\n";

try {
    if ($id) {
        $booking = Booking::find($id);
    } else {
        $booking = Booking::latest()->first();
    }

    if (! $booking) {
        echo "No booking found\n";
        exit(1);
    }

    echo "Marking booking {$booking->id} as completed (email: {$booking->email})...\n";

    $booking->updateStatus('completed', 'CLI Runner', 'Completed via tools/complete_booking.php', $booking->final_price, $booking->service_duration_minutes);

    echo "Done — notification attempted. Booking ID: {$booking->id}\n";
    exit(0);
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(2);
}
