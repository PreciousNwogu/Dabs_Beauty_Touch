<?php
// Usage: php tools/inspect_booking.php 253
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;

$id = $argv[1] ?? null;
if (!$id) {
    echo "Usage: php tools/inspect_booking.php <booking_id>\n";
    exit(1);
}

$b = Booking::find($id);
if (!$b) {
    echo "Booking with id {$id} not found.\n";
    exit(1);
}

$out = [
    'id' => $b->id,
    'booking_id' => 'BK' . str_pad($b->id, 6, '0', STR_PAD_LEFT),
    'service' => $b->service,
    'service_type' => $b->service_type ?? null,
    'length' => $b->length,
    'kb_length' => $b->kb_length ?? null,
    'kb_braid_type' => $b->kb_braid_type ?? null,
    'kb_finish' => $b->kb_finish ?? null,
    'kb_extras' => $b->kb_extras ?? null,
    'base_price' => $b->base_price ?? null,
    'length_adjustment' => $b->length_adjustment ?? null,
    'final_price' => $b->final_price ?? null,
    'hair_mask_option' => $b->hair_mask_option ?? null,
    'notes' => $b->notes ?? null,
];

echo "Booking raw fields:\n";
echo json_encode($out, JSON_PRETTY_PRINT) . "\n\n";

try {
    $break = $b->getPricingBreakdown();
    echo "getPricingBreakdown output:\n";
    echo json_encode($break, JSON_PRETTY_PRINT) . "\n";
} catch (\Throwable $e) {
    echo "Error computing breakdown: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
