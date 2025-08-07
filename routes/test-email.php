<?php

use Illuminate\Support\Facades\Route;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingConfirmation;
use App\Notifications\AdminBookingNotification;
use Illuminate\Support\Facades\Mail;

// View recent email logs
Route::get('/view-email-logs', function () {
    $logPath = storage_path('logs/laravel.log');
    
    if (!file_exists($logPath)) {
        return response()->json([
            'message' => 'No log file found',
            'path' => $logPath
        ]);
    }
    
    $logContent = file_get_contents($logPath);
    $lines = explode("\n", $logContent);
    
    // Get last 50 lines that contain email-related content
    $emailLines = array_filter($lines, function($line) {
        return strpos($line, 'mail') !== false || 
               strpos($line, 'Mail') !== false ||
               strpos($line, 'Subject:') !== false ||
               strpos($line, 'To:') !== false ||
               strpos($line, 'From:') !== false;
    });
    
    $recentEmailLines = array_slice(array_reverse($emailLines), 0, 20);
    
    return response()->json([
        'message' => 'Recent email logs (last 20 email-related entries)',
        'logs' => $recentEmailLines,
        'total_lines' => count($lines),
        'email_lines' => count($emailLines)
    ]);
});

// Configuration debug test
Route::get('/test-config', function () {
    return response()->json([
        'mail_config' => [
            'mailer' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'username' => config('mail.mailers.smtp.username'),
            'password' => substr(config('mail.mailers.smtp.password'), 0, 10) . '...',
            'encryption' => config('mail.mailers.smtp.encryption'),
            'from_address' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
        ],
        'php_version' => PHP_VERSION,
        'laravel_version' => app()->version()
    ]);
});

// Simple Mailtrap connection test
Route::get('/test-simple-email', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('Hello! This is a simple test email from Dabs Beauty Touch. If you receive this, your Mailtrap configuration is working correctly!', function ($message) {
            $message->to('test@example.com')
                    ->subject('Simple Mailtrap Test - Dabs Beauty Touch')
                    ->from('hello@example.com', 'Dabs Beauty Touch');
        });

        return response()->json([
            'success' => true,
            'message' => '🎉 Simple test email sent successfully!',
            'instructions' => 'Check your Mailtrap inbox for the plain text email.'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => '❌ Failed to send simple email: ' . $e->getMessage(),
            'line' => $e->getLine(),
            'file' => basename($e->getFile())
        ]);
    }
});

// Mailtrap test routes
Route::get('/test-mailtrap', function () {
    try {
        // Test data
        $testData = [
            'subject' => '🧪 Mailtrap Test - Dabs Beauty Touch',
            'greeting' => 'Hello! This is a test email.',
            'lines' => [
                '✅ This email was sent successfully via Mailtrap!',
                '📧 Your email configuration is working correctly.',
                '🎯 You can now test your booking notifications.',
                '',
                'Test Booking Details:',
                'Service: Hair Braiding Test',
                'Date: ' . date('F j, Y'),
                'Time: 10:00 AM',
                'Customer: Test Customer'
            ],
            'action' => [
                'text' => 'Visit Website',
                'url' => url('/')
            ],
            'outro' => 'This test was sent from your Laravel application to verify Mailtrap integration.'
        ];

        // Send test email
        Mail::to('test@example.com')->send(new \App\Mail\TestMail($testData));

        return response()->json([
            'success' => true,
            'message' => '🎉 Test email sent successfully! Check your Mailtrap inbox.',
            'instructions' => [
                '1. Go to https://mailtrap.io and log in',
                '2. Open your inbox',
                '3. You should see the test email',
                '4. Click on it to view the content',
                '5. Verify the styling and information display correctly'
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => '❌ Failed to send test email: ' . $e->getMessage(),
            'troubleshooting' => [
                '1. Check your .env file has correct Mailtrap credentials',
                '2. Make sure MAIL_MAILER=smtp',
                '3. Verify MAIL_HOST=sandbox.smtp.mailtrap.io',
                '4. Check your Mailtrap username and password are correct',
                '5. Ensure your Mailtrap account is active'
            ]
        ]);
    }
});

// Test booking notification route for Mailtrap
Route::get('/test-booking-emails-mailtrap', function () {
    try {
        // Create test booking
        $booking = new \App\Models\Booking([
            'name' => 'Jane Smith',
            'email' => 'customer@example.com', 
            'phone' => '(555) 123-4567',
            'service' => 'Knotless Braids',
            'appointment_date' => '2024-02-15',
            'appointment_time' => '2:00 PM',
            'message' => 'Looking forward to my appointment!',
            'status' => 'pending'
        ]);

        $bookingId = 'BK' . date('Ymd') . '001';
        $confirmationCode = 'CONF' . strtoupper(substr(md5(uniqid()), 0, 8));

        // Create customer and admin mailable objects
        $customerMail = new \App\Mail\BookingConfirmationMail($booking, $bookingId, $confirmationCode);
        $adminMail = new \App\Mail\AdminBookingNotificationMail($booking, $bookingId, $confirmationCode);

        // Send customer email via Mailtrap
        Mail::to($booking->email)->send($customerMail);
        
        // Send admin email via Mailtrap  
        Mail::to('admin@dabsbeautytouch.com')->send($adminMail);

        return response()->json([
            'success' => true,
            'message' => '🎉 Both booking notification emails sent to Mailtrap!',
            'details' => [
                'customer_email' => $booking->email,
                'admin_email' => 'admin@dabsbeautytouch.com',
                'booking_id' => $bookingId,
                'confirmation_code' => $confirmationCode,
                'service' => $booking->service,
                'date' => $booking->appointment_date,
                'time' => $booking->appointment_time
            ],
            'instructions' => [
                '1. Check your Mailtrap inbox',
                '2. You should see 2 emails: one for customer, one for admin',
                '3. Click on each to verify content and styling',
                '4. Test different booking scenarios as needed'
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => '❌ Failed to send booking emails: ' . $e->getMessage(),
            'error_details' => $e->getTraceAsString()
        ]);
    }
});

Route::get('/test-email-simple', function () {
    try {
        // Create a test booking
        $testBooking = new Booking();
        $testBooking->name = 'Test Customer';
        $testBooking->email = 'test@example.com';
        $testBooking->phone = '(123) 456-7890';
        $testBooking->service = 'Box Braids';
        $testBooking->appointment_date = now()->addDays(7);
        $testBooking->appointment_time = '14:00';
        $testBooking->message = 'This is a test booking';
        $testBooking->status = 'pending';
        
        // Create test user for customer
        $customerUser = new User();
        $customerUser->name = 'Test Customer';
        $customerUser->email = 'test@example.com';
        
        // Send customer notification
        $customerUser->notify(new BookingConfirmation(
            $testBooking, 
            'BK123456', 
            'CONF12345678'
        ));
        
        // Create admin user
        $adminUser = new User();
        $adminUser->name = 'Admin';
        $adminUser->email = 'admin@dabsbeautytouch.com';
        
        // Send admin notification
        $adminUser->notify(new AdminBookingNotification(
            $testBooking, 
            'BK123456', 
            'CONF12345678'
        ));
        
        return response()->json([
            'success' => true,
            'message' => 'Test emails sent! Check the Laravel log file for email content.',
            'log_location' => 'storage/logs/laravel.log'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});
