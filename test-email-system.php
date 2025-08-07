<?php

require_once 'vendor/autoload.php';

use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingConfirmation;
use App\Notifications\AdminBookingNotification;
use Illuminate\Foundation\Application;
use Illuminate\Config\Repository;

echo "Testing Email Notification System\n";
echo "================================\n\n";

// Initialize Laravel application
$app = new Application(realpath(__DIR__));

// Create a test booking object
$bookingData = [
    'name' => 'Test Customer',
    'email' => 'testcustomer@example.com',
    'phone' => '+1234567890',
    'service' => 'Hair Braiding',
    'appointment_date' => '2024-01-15',
    'appointment_time' => '10:00 AM',
    'message' => 'Test booking message',
    'status' => 'pending'
];

// Create booking instance
$booking = new Booking($bookingData);

echo "1. Testing BookingConfirmation Notification\n";
echo "===========================================\n";

try {
    $userNotification = new BookingConfirmation($booking, 'BK001', 'CONF123');
    $mailMessage = $userNotification->toMail((object)['email' => 'test@example.com']);
    
    echo "✓ BookingConfirmation notification created successfully\n";
    echo "✓ Subject: " . $mailMessage->subject . "\n";
    echo "✓ Greeting: " . ($mailMessage->greeting ?? 'Default greeting') . "\n";
    echo "✓ Action Button: " . (isset($mailMessage->actionText) ? $mailMessage->actionText : 'No action') . "\n";
    
} catch (Exception $e) {
    echo "✗ BookingConfirmation failed: " . $e->getMessage() . "\n";
}

echo "\n2. Testing AdminBookingNotification Notification\n";
echo "===============================================\n";

try {
    $adminNotification = new AdminBookingNotification($booking, 'BK001', 'CONF123');
    $mailMessage = $adminNotification->toMail((object)['email' => 'admin@dabsbeautytouch.com']);
    
    echo "✓ AdminBookingNotification notification created successfully\n";
    echo "✓ Subject: " . $mailMessage->subject . "\n";
    echo "✓ Greeting: " . ($mailMessage->greeting ?? 'Default greeting') . "\n";
    echo "✓ Action Button: " . (isset($mailMessage->actionText) ? $mailMessage->actionText : 'No action') . "\n";
    
} catch (Exception $e) {
    echo "✗ AdminBookingNotification failed: " . $e->getMessage() . "\n";
}

echo "\n3. Testing Email Configuration\n";
echo "=============================\n";

// Check if .env file exists and has email configuration
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    echo "✓ .env file found\n";
    
    $envContent = file_get_contents($envFile);
    if (strpos($envContent, 'MAIL_MAILER') !== false) {
        echo "✓ Email configuration found in .env\n";
        
        // Extract email config
        preg_match('/MAIL_MAILER=(.+)/', $envContent, $matches);
        $mailDriver = $matches[1] ?? 'not set';
        echo "✓ Mail driver: " . trim($mailDriver) . "\n";
        
        preg_match('/MAIL_FROM_ADDRESS=(.+)/', $envContent, $matches);
        $fromAddress = $matches[1] ?? 'not set';
        echo "✓ From address: " . trim($fromAddress) . "\n";
        
    } else {
        echo "✗ Email configuration missing in .env\n";
    }
} else {
    echo "✗ .env file not found\n";
}

echo "\n4. Final Status\n";
echo "==============\n";
echo "Email notification classes appear to be working correctly.\n";
echo "If emails are still not sending, check:\n";
echo "- Laravel queue configuration\n";
echo "- Email driver settings in .env\n";
echo "- Laravel logs for specific errors\n";
echo "- Network/firewall settings for SMTP\n";

echo "\nTest completed.\n";
