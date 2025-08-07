<?php

// Simple email test script
require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingConfirmation;
use App\Notifications\AdminBookingNotification;

// Create test booking
$booking = new Booking();
$booking->name = 'Test Customer';
$booking->email = 'test@example.com';
$booking->phone = '(123) 456-7890';
$booking->service = 'Box Braids';
$booking->appointment_date = now()->addDays(7)->format('Y-m-d');
$booking->appointment_time = '14:00';
$booking->message = 'Test message';
$booking->status = 'pending';

try {
    // Test customer notification
    $customer = new User();
    $customer->name = 'Test Customer';
    $customer->email = 'test@example.com';
    
    $customer->notify(new BookingConfirmation($booking, 'BK123456', 'CONF12345678'));
    echo "✅ Customer email sent successfully!\n";
    
    // Test admin notification  
    $admin = new User();
    $admin->name = 'Admin';
    $admin->email = 'admin@dabsbeautytouch.com';
    
    $admin->notify(new AdminBookingNotification($booking, 'BK123456', 'CONF12345678'));
    echo "✅ Admin email sent successfully!\n";
    
    echo "\n📧 Check storage/logs/laravel.log for email content\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
