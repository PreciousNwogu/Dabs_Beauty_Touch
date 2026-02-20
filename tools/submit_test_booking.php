<?php
// tools/submit_test_booking.php
// Create a test booking directly via models (no CSRF, no HTTP middleware).
// Usage: php tools/submit_test_booking.php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
// Bootstrap the application (console kernel) so Eloquent, config, etc. are available
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Log;

// Adjust these values for your test
$payload = [
    'name' => 'Test Tailbone',
    'email' => 'test+tailbone@example.com',
    'phone' => '+15555551234',
    'service' => 'Medium Knotless Braids',
    'service_type' => 'medium-knotless',
    'length' => 'tailbone', // normalized form
    'appointment_date' => date('Y-m-d', strtotime('+2 days')),
    'appointment_time' => '10:00',
    // client-computed final price (what we want persisted)
    'final_price_override' => 190.00,
    'message' => 'Automated test booking for tailbone length'
];

try {
    // Resolve service model if available
    $serviceModel = null;
    if (!empty($payload['service_type'])) {
        $serviceModel = \App\Models\Service::where('slug', $payload['service_type'])->orWhere('name', $payload['service'])->first();
    }

    $basePrice = $serviceModel ? (float) $serviceModel->base_price : 150.00;

    // Compute server-side adjustment the same way as controller (best-effort)
    $ordered = ['neck','shoulder','armpit','bra_strap','mid_back','waist','hip','tailbone','classic'];
    $midIndex = array_search('mid_back', $ordered, true);
    $idx = array_search($payload['length'], $ordered, true);
    $adjust = 0.0;
    if ($idx !== false && $midIndex !== false) {
        $adjust = ($idx - $midIndex) * 20.00;
    }
    $serverCalculated = round($basePrice + $adjust, 2);

    // Use client override if present
    $finalPrice = isset($payload['final_price_override']) ? round((float)$payload['final_price_override'], 2) : $serverCalculated;

    $bookingData = [
        'name' => $payload['name'],
        'email' => $payload['email'],
        'phone' => $payload['phone'],
        'service' => $payload['service'],
        'service_type' => $payload['service_type'] ?? null,
        'appointment_date' => $payload['appointment_date'],
        'appointment_time' => $payload['appointment_time'],
        'message' => $payload['message'] ?? null,
        'status' => 'pending',
        'base_price' => $basePrice,
        'length_adjustment' => $adjust,
        'final_price' => $finalPrice,
        'length' => $payload['length'],
    ];

    // Create the booking
    $booking = \App\Models\Booking::create($bookingData);

    // Generate booking id & confirmation code like the app does
    $bookingId = 'BK' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
    $confirmationCode = 'CONF' . strtoupper(substr(md5($booking->id . time()), 0, 8));
    $booking->confirmation_code = $confirmationCode;
    $booking->save();

    echo "Created booking id: {$booking->id} (" . $bookingId . ")\n";
    echo "Service: {$booking->service} ({$booking->service_type})\n";
    echo "Length: {$booking->length}\n";
    echo "Base price: {$booking->base_price}\n";
    echo "Length adjustment: {$booking->length_adjustment}\n";
    echo "Final price persisted: {$booking->final_price}\n";
    echo "Confirmation code: {$confirmationCode}\n";

    // Log an info entry for traceability
    Log::info('tools/submit_test_booking created booking', ['id' => $booking->id, 'final_price' => $booking->final_price, 'server_calc' => $serverCalculated]);

    // Attempt to send customer notification (try Notification::route then Mail fallback)
    try {
        if (!empty($booking->email) && $booking->email !== 'no-email@example.com') {
            try {
                \Illuminate\Support\Facades\Notification::route('mail', $booking->email)->sendNow(new \App\Notifications\BookingConfirmation($booking));
                echo "Customer notification sent via Notification facade to {$booking->email}\n";
                Log::info('Customer notification sent (Notification::route)', ['booking_id' => $booking->id, 'email' => $booking->email]);
            } catch (\Throwable $notifyErr) {
                Log::warning('Notification::route sendNow failed, attempting Mail fallback', ['booking_id' => $booking->id, 'error' => $notifyErr->getMessage()]);
                try {
                    \Illuminate\Support\Facades\Mail::to($booking->email)->send(new \App\Mail\BookingConfirmationMail($booking));
                    echo "Customer notification sent via Mail::to() fallback to {$booking->email}\n";
                    Log::info('Customer notification sent (Mail fallback)', ['booking_id' => $booking->id, 'email' => $booking->email]);
                } catch (\Throwable $mailErr) {
                    echo "Failed to send customer notification: {$mailErr->getMessage()}\n";
                    Log::error('Customer Mail fallback failed', ['booking_id' => $booking->id, 'error' => $mailErr->getMessage()]);
                }
            }
        } else {
            echo "No customer email provided; skipping customer notification\n";
            Log::info('No customer email to send notification', ['booking_id' => $booking->id]);
        }
    } catch (\Throwable $e) {
        Log::warning('Unexpected error while sending customer notification', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
    }

    // Attempt to notify admin
    try {
        $adminEmail = env('BOOKING_NOTIFICATION_EMAIL') ?: env('ADMIN_EMAIL') ?: config('mail.from.address');
        try {
            \Illuminate\Support\Facades\Notification::route('mail', $adminEmail)->sendNow(new \App\Notifications\AdminBookingNotification($booking));
            echo "Admin notification sent to {$adminEmail}\n";
            Log::info('Admin notification sent (Notification::route)', ['booking_id' => $booking->id, 'admin' => $adminEmail]);
        } catch (\Throwable $adminNotifyErr) {
            Log::warning('Admin notification sendNow failed, attempting Mail fallback', ['booking_id' => $booking->id, 'error' => $adminNotifyErr->getMessage()]);
            try {
                \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\BookingConfirmationMail($booking));
                echo "Admin notification sent via Mail fallback to {$adminEmail}\n";
                Log::info('Admin notification sent (Mail fallback)', ['booking_id' => $booking->id, 'admin' => $adminEmail]);
            } catch (\Throwable $adminMailErr) {
                echo "Failed to send admin notification: {$adminMailErr->getMessage()}\n";
                Log::error('Admin Mail fallback failed', ['booking_id' => $booking->id, 'error' => $adminMailErr->getMessage()]);
            }
        }
    } catch (\Throwable $e) {
        Log::warning('Unexpected error while sending admin notification', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
    }

    exit(0);
} catch (\Exception $e) {
    fwrite(STDERR, "Error creating booking: " . $e->getMessage() . "\n");
    Log::error('tools/submit_test_booking failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    exit(1);
}

