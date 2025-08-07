<?php

// Create a simple test route for sending emails
Route::get('/test-email-notifications', function () {
    try {
        // Create a test booking
        $bookingData = [
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'phone' => '+1234567890',
            'service' => 'Hair Braiding',
            'appointment_date' => '2024-01-15',
            'appointment_time' => '10:00 AM',
            'message' => 'This is a test booking',
            'status' => 'pending'
        ];
        
        // Create booking model instance
        $booking = new App\Models\Booking($bookingData);
        
        // Generate test IDs
        $bookingId = 'TEST001';
        $confirmationCode = 'CONF' . rand(100, 999);
        
        // Test 1: Send customer confirmation
        try {
            $customerEmail = 'customer@example.com';
            $customerNotifiable = (object)['email' => $customerEmail];
            
            $customerNotification = new App\Notifications\BookingConfirmation($booking, $bookingId, $confirmationCode);
            
            // Use Laravel's notification system
            Notification::route('mail', $customerEmail)
                ->notify($customerNotification);
                
            $customerResult = "✓ Customer email sent successfully";
        } catch (Exception $e) {
            $customerResult = "✗ Customer email failed: " . $e->getMessage();
        }
        
        // Test 2: Send admin notification
        try {
            $adminEmail = 'admin@dabsbeautytouch.com';
            
            $adminNotification = new App\Notifications\AdminBookingNotification($booking, $bookingId, $confirmationCode);
            
            // Use Laravel's notification system
            Notification::route('mail', $adminEmail)
                ->notify($adminNotification);
                
            $adminResult = "✓ Admin email sent successfully";
        } catch (Exception $e) {
            $adminResult = "✗ Admin email failed: " . $e->getMessage();
        }
        
        // Return results
        return response()->json([
            'status' => 'completed',
            'customer_notification' => $customerResult,
            'admin_notification' => $adminResult,
            'booking_id' => $bookingId,
            'confirmation_code' => $confirmationCode,
            'mail_driver' => config('mail.default'),
            'log_location' => storage_path('logs/laravel.log')
        ], 200);
        
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Simple email test route
Route::get('/simple-email-test', function() {
    try {
        // Send a simple test email
        Mail::raw('This is a test email from Dabs Beauty Touch booking system.', function ($message) {
            $message->to('test@example.com')
                    ->subject('Test Email - Dabs Beauty Touch')
                    ->from(config('mail.from.address'), config('mail.from.name'));
        });
        
        return response()->json([
            'status' => 'success',
            'message' => 'Simple test email sent successfully',
            'mail_driver' => config('mail.default'),
            'from_address' => config('mail.from.address'),
            'from_name' => config('mail.from.name')
        ]);
        
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});
