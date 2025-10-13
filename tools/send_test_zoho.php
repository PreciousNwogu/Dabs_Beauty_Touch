<?php
// tools/send_test_zoho.php
// Usage: php tools/send_test_zoho.php recipient@example.com [--env-file=.env.zoho]
//        php tools/send_test_zoho.php recipient@example.com --zoho
// Loads an env file (use --zoho to load .env.zoho) and attempts to send a simple test notification via the configured mailer.

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
$recipient = null;
foreach ($rawArgs as $arg) {
    if (str_starts_with($arg, '--env-file=')) {
        $envFile = substr($arg, strlen('--env-file='));
        continue;
    }
    if ($arg === '--zoho' || $arg === '--use-zoho') {
        $envFile = __DIR__ . '/../.env.zoho';
        continue;
    }
    if (! str_starts_with($arg, '--')) {
        // first positional arg is recipient
        if (! $recipient) $recipient = $arg;
    }
}

if (! $recipient) {
    fwrite(STDERR, "Usage: php tools/send_test_zoho.php recipient@example.com [--env-file=.env.zoho|--zoho]\n");
    exit(1);
}

if ($envFile) {
    loadEnvFile($envFile);
} else {
    // No override provided — the script will use the project's .env (Laravel's bootstrap will load it).
    echo "No env override provided — using project's .env file\n";
}

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

// Debug: print effective MAIL_* values
echo "Using MAIL_MAILER=" . (getenv('MAIL_MAILER') ?: 'null') . "\n";
echo "Using MAIL_HOST=" . (getenv('MAIL_HOST') ?: 'null') . "\n";
echo "Using MAIL_PORT=" . (getenv('MAIL_PORT') ?: 'null') . "\n";
echo "Using MAIL_USERNAME=" . (getenv('MAIL_USERNAME') ?: 'null') . "\n";

// Create an ad-hoc notification class that sends a simple MailMessage
$testNotification = new class extends BaseNotification {
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('DBT — Zoho test message')
            ->line('This is a test message sent via the CLI tools/send_test_zoho.php script using the current MAIL_* settings.')
            ->line('If you see this, Zoho SMTP is correctly configured for this process.');
    }
};

try {
    echo "Sending test message to {$recipient}...\n";
    Notification::route('mail', $recipient)->notify($testNotification);
    echo "Done — notification attempted. Check recipient inbox and storage/logs/laravel.log for details.\n";
    exit(0);
} catch (\Throwable $e) {
    echo "Failed to send test message: " . $e->getMessage() . "\n";
    exit(2);
}
