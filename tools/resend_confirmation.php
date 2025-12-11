<?php
// Usage: php tools/resend_confirmation.php <booking_id> [new_length]
// If new_length is provided, booking length (and price fields) will be updated before resending.
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;
use Illuminate\Support\Facades\Notification;

$id = $argv[1] ?? null;
$newLength = $argv[2] ?? null;
if (!$id) {
    echo "Usage: php tools/resend_confirmation.php <booking_id> [new_length]\n";
    exit(1);
}

$b = Booking::find($id);
if (!$b) {
    echo "Booking {$id} not found.\n";
    exit(1);
}

if ($newLength) {
    echo "Updating booking {$id} length -> {$newLength}\n";
    $b->length = $newLength;
    // recompute length_adjust as controller does
    $ordered = ['neck','shoulder','armpit','bra_strap','mid_back','waist','hip','tailbone','classic'];
    $midIndex = array_search('mid_back', $ordered, true);
    $idx = array_search($b->length, $ordered, true);
    $adjust = 0.0;
    if ($idx !== false && $midIndex !== false) {
        $d = $idx - $midIndex;
        $adjust = ($d * 20.0);
    }
    $b->length_adjustment = $adjust;
    // recompute final price using service model if present
    try {
        $serviceModel = \App\Models\Service::where('slug', $b->service)->orWhere('name', $b->service)->first();
        $base = $serviceModel ? (float)$serviceModel->base_price : ($b->base_price ?? 150.0);
    } catch (\Throwable $e) {
        $base = $b->base_price ?? 150.0;
    }
    $b->base_price = $base;
    $b->final_price = round($base + $b->length_adjustment, 2);
    $b->save();
    echo "Updated price fields: base_price={$b->base_price}, length_adjustment={$b->length_adjustment}, final_price={$b->final_price}\n";
}

// Build and log breakdown for transparency
try{
    $break = $b->getPricingBreakdown();
    echo "Breakdown: " . json_encode($break, JSON_PRETTY_PRINT) . "\n";
} catch (\Throwable $e) {
    echo "Error computing breakdown: " . $e->getMessage() . "\n";
}

if (empty($b->email) || $b->email === 'no-email@example.com') {
    echo "No valid email on booking; aborting send.\n";
    exit(1);
}

// Attempt to send via Notification route (respecting current Notification class)
try {
    Notification::route('mail', $b->email)->notify(new \App\Notifications\BookingConfirmation($b));
    echo "Notification dispatched to {$b->email}\n";
} catch (\Throwable $e) {
    echo "Notification failed: " . $e->getMessage() . "\n";
    try {
        \Illuminate\Support\Facades\Mail::to($b->email)->send(new \App\Mail\BookingConfirmationMail($b));
        echo "Mail fallback sent to {$b->email}\n";
    } catch (\Throwable $mailEx) {
        echo "Mail fallback failed: " . $mailEx->getMessage() . "\n";
    }
}
