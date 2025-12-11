<?php
// Quick test harness to inspect Booking::getPricingBreakdown()
// Run from project root: php tools/test_pricing.php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;

// Simulate the booking reported (smedium knotless tailbone)
$booking = new Booking([
    'id' => 999999,
    'service' => 'Smedium Knotless Braids',
    'service_type' => 'knotless',
    'kb_braid_type' => 'knotless_med',
    'kb_length' => 'tailbone',
    'kb_finish' => null,
    'kb_extras' => null,
    'length' => 'tailbone',
    'base_price' => 150.00,
    'length_adjustment' => null,
    'final_price' => null,
    'notes' => null,
]);

try {
    $break = $booking->getPricingBreakdown();
    echo "Pricing breakdown for simulated booking:\n\n";
    echo json_encode($break, JSON_PRETTY_PRINT) . "\n";
} catch (\Throwable $e) {
    echo "Error computing breakdown: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
