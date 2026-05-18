<?php
// tools/test_booking_flow.php
// Simple script to create a booking and trigger customer + admin notifications
// Run with: php tools/test_booking_flow.php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

// Create a test booking
$bookingData = [
    'name' => 'Test User',
    'email' => 'testuser+copilot@example.com',
    'phone' => '555-0000',
    'service' => 'Test Service',
    'appointment_type' => 'mobile',
    'address' => '123 Test Street',
    'parking_type' => 'paid',
    'appointment_date' => date('Y-m-d', strtotime('+7 days')),
    'appointment_time' => '10:00',
    'message' => 'Test booking from script',
    'status' => 'pending'
];

$booking = new App\Models\Booking($bookingData);
$booking->save();

echo "Created booking id={$booking->id} email={$booking->email}\n";
echo "Saved parking_type={$booking->parking_type}\n";

// Send customer confirmation
try {
    if ($booking->email && $booking->email !== 'no-email@example.com') {
        Notification::route('mail', $booking->email)->notify(new App\Notifications\BookingConfirmation($booking));
        echo "Customer BookingConfirmation dispatched to {$booking->email}\n";
    }
} catch (\Throwable $e) {
    echo "Customer notification failed: " . $e->getMessage() . "\n";
}

// Send admin notification once
try {
    $adminEmail = env('BOOKING_NOTIFICATION_EMAIL') ?: env('ADMIN_EMAIL') ?: config('mail.from.address');
    // Only send if not already marked
    if (empty($booking->admin_notified)) {
        Notification::route('mail', $adminEmail)->notify(new App\Notifications\AdminBookingNotification($booking));
        $booking->admin_notified = true;
        $booking->save();
        echo "Admin AdminBookingNotification dispatched to {$adminEmail}\n";
    } else {
        echo "Admin already notified for booking id={$booking->id}\n";
    }
} catch (\Throwable $e) {
    echo "Admin notification failed: " . $e->getMessage() . "\n";
}

echo "Done. Check storage/logs/laravel.log for details.\n";
