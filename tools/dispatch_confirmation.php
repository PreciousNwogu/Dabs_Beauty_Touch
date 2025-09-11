<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Use Eloquent and Notification facades
use App\Models\Booking;
use Illuminate\Support\Facades\Notification;

$booking = Booking::latest()->first();

if (! $booking) {
    echo "No bookings found\n";
    exit(1);
}

echo "Booking ID: " . $booking->id . "\n";
echo "Email: " . ($booking->email ?? 'NULL') . "\n";
echo "Confirmation code: " . ($booking->confirmation_code ?? 'NULL') . "\n";
echo "Final price: " . ($booking->final_price ?? 'NULL') . "\n";
echo "Length: " . ($booking->length ?? 'NULL') . "\n";

try {
    Notification::route('mail', $booking->email)->notify(new App\Notifications\BookingConfirmation($booking));
    echo "Notification dispatched to " . ($booking->email ?? 'NULL') . "\n";
} catch (\Throwable $e) {
    echo "Notification failed: " . $e->getMessage() . "\n";
    exit(2);
}

exit(0);
