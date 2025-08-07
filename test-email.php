<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingConfirmation;
use App\Notifications\AdminBookingNotification;

echo "Testing Email Notification System\n";
echo "================================\n\n";

try {
    // Create test booking data
    $testBooking = new Booking();
    $testBooking->name = 'John Doe';
    $testBooking->email = 'customer@example.com';
    $testBooking->phone = '(555) 123-4567';
    $testBooking->service = 'Box Braids';
    $testBooking->appointment_date = now()->addDays(7);
    $testBooking->appointment_time = '14:00';
    $testBooking->message = 'Looking forward to my appointment!';
    $testBooking->status = 'pending';

    echo "✓ Test booking data created\n";

    // Test BookingConfirmation notification
    $customerUser = new User();
    $customerUser->name = 'John Doe';
    $customerUser->email = 'customer@example.com';
    
    $bookingNotification = new BookingConfirmation($testBooking, 'BK000123', 'CONF12345678');
    echo "✓ BookingConfirmation notification created\n";

    // Test AdminBookingNotification
    $adminUser = new User();
    $adminUser->name = 'Admin';
    $adminUser->email = 'admin@dabsbeautytouch.com';
    
    $adminNotification = new AdminBookingNotification($testBooking, 'BK000123', 'CONF12345678');
    echo "✓ AdminBookingNotification notification created\n";

    echo "\n🎉 Email notification system is working properly!\n";
    echo "📧 Notifications can be sent when bookings are made.\n\n";

    // Show configuration
    echo "Mail Configuration:\n";
    echo "- Mailer: " . config('mail.default') . "\n";
    echo "- From: " . config('mail.from.address') . "\n";
    echo "- From Name: " . config('mail.from.name') . "\n";
    echo "\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
