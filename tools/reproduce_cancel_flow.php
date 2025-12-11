<?php
// tools/reproduce_cancel_flow.php
// Boots the Laravel app, marks a booking as cancelled, and sends the BookingCancelledNotification.

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;
use App\Notifications\BookingCancelledNotification;
use Illuminate\Support\Facades\Notification;

try {
    // Find latest non-cancelled booking with an email
    $booking = Booking::where('status', '!=', 'cancelled')
        ->whereNotNull('email')
        ->orderByDesc('id')
        ->first();

    if (! $booking) {
        echo "No non-cancelled booking with email found.\n";
        exit(0);
    }

    $cancelledBy = 'CLI Test';
    $booking->status = 'cancelled';
    $booking->cancelled_at = now();
    // set cancelled_by if attribute exists
    if (array_key_exists('cancelled_by', $booking->getAttributes())) {
        $booking->cancelled_by = $cancelledBy;
    }
    $booking->save();

    echo "Booking ID {$booking->id} marked cancelled. Sending notification to {$booking->email}...\n";

    Notification::route('mail', $booking->email)->notify(new BookingCancelledNotification($booking, $cancelledBy));

    echo "Notification attempted. Check storage/logs/laravel.log and your mail provider.\n";

    file_put_contents(__DIR__ . '/../storage/logs/reproduce_cancel_result.txt', "OK: Booking {$booking->id} cancelled and notification attempted to {$booking->email}\n");
} catch (Throwable $e) {
    $msg = "ERR: " . $e->getMessage() . "\n" . $e->getTraceAsString();
    echo $msg . "\n";
    file_put_contents(__DIR__ . '/../storage/logs/reproduce_cancel_result.txt', $msg);
    exit(1);
}
