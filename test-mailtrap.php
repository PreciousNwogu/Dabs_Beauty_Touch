<?php

require_once 'vendor/autoload.php';

use App\Models\Booking;
use App\Notifications\BookingConfirmation;
use App\Notifications\AdminBookingNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

echo "🧪 Mailtrap Email Testing Script\n";
echo "==============================\n\n";

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "✅ Laravel bootstrapped successfully\n";

// Test basic email configuration
echo "\n📧 Testing Email Configuration...\n";
echo "Mail Driver: " . config('mail.default') . "\n";
echo "Mail Host: " . config('mail.mailers.smtp.host') . "\n";
echo "Mail Port: " . config('mail.mailers.smtp.port') . "\n";
echo "From Address: " . config('mail.from.address') . "\n";
echo "From Name: " . config('mail.from.name') . "\n";

// Create test booking data
$bookingData = [
    'name' => 'Test Customer',
    'email' => 'test@example.com',
    'phone' => '+1234567890',
    'service' => 'Hair Braiding Test',
    'appointment_date' => '2024-01-15',
    'appointment_time' => '10:00 AM',
    'message' => 'This is a test booking for Mailtrap',
    'status' => 'pending'
];

$booking = new Booking($bookingData);

echo "\n🧪 Test 1: Customer Booking Confirmation Email\n";
echo "==============================================\n";

try {
    // Send customer notification
    Mail::to('customer@example.com')->send(new \App\Mail\TestMail([
        'subject' => 'Test Customer Booking Confirmation - Mailtrap',
        'greeting' => 'Hello Test Customer!',
        'lines' => [
            'This is a test email from Dab\'s Beauty Touch booking system.',
            'Your booking details:',
            'Service: ' . $bookingData['service'],
            'Date: ' . $bookingData['appointment_date'],
            'Time: ' . $bookingData['appointment_time'],
            'Phone: ' . $bookingData['phone']
        ],
        'action' => [
            'text' => 'View Booking Details',
            'url' => 'http://localhost:8000'
        ],
        'outro' => 'Thank you for choosing Dab\'s Beauty Touch!'
    ]));
    
    echo "✅ Customer email sent successfully to Mailtrap!\n";
    
} catch (Exception $e) {
    echo "❌ Customer email failed: " . $e->getMessage() . "\n";
}

echo "\n🧪 Test 2: Admin Booking Notification Email\n";
echo "===========================================\n";

try {
    // Send admin notification
    Mail::to('admin@dabsbeautytouch.com')->send(new \App\Mail\TestMail([
        'subject' => 'Test Admin Booking Alert - Mailtrap',
        'greeting' => 'New Booking Alert!',
        'lines' => [
            'A new appointment has been booked (TEST MODE).',
            'Customer Details:',
            'Name: ' . $bookingData['name'],
            'Email: ' . $bookingData['email'],
            'Phone: ' . $bookingData['phone'],
            'Service: ' . $bookingData['service'],
            'Date: ' . $bookingData['appointment_date'],
            'Time: ' . $bookingData['appointment_time']
        ],
        'action' => [
            'text' => 'View in Admin Panel',
            'url' => 'http://localhost:8000/admin'
        ],
        'outro' => 'Please contact the customer to arrange deposit payment.'
    ]));
    
    echo "✅ Admin email sent successfully to Mailtrap!\n";
    
} catch (Exception $e) {
    echo "❌ Admin email failed: " . $e->getMessage() . "\n";
}

echo "\n📝 Instructions:\n";
echo "================\n";
echo "1. Check your Mailtrap inbox at https://mailtrap.io\n";
echo "2. You should see 2 test emails in your inbox\n";
echo "3. Click on each email to view content and formatting\n";
echo "4. Check that all booking details are displayed correctly\n";
echo "5. Verify the 'From' address shows as 'Dab's Beauty Touch'\n";

echo "\n🔧 Next Steps:\n";
echo "==============\n";
echo "1. Update your .env file with real Mailtrap credentials\n";
echo "2. Test a real booking through your website\n";
echo "3. Check Mailtrap for the actual notification emails\n";
echo "4. When ready for production, switch back to real SMTP\n";

echo "\n✨ Test completed!\n";
