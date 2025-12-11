<?php
// Usage: php tools/list_problem_bookings.php [from_date]
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;

$from = $argv[1] ?? date('Y-m-01');

use Illuminate\Support\Facades\Schema;

$qb = Booking::where(function($q){
        $q->where('service', 'like', '%knot%')
            ->orWhere('service', 'like', '%braid%')
            ->orWhere('service', 'like', '%knotless%');
});

// If the `service_type` column exists in this DB, include it in the search
if (Schema::hasColumn('bookings', 'service_type')) {
        $qb->orWhere(function($q){
                $q->where('service_type', 'like', '%knot%')
                    ->orWhere('service_type', 'like', '%braid%');
        });
}

$qb->where(function($q){
    $q->whereNull('length')->orWhere('length', 'mid_back')->orWhere('length', '');
});

$qb->where('created_at', '>=', $from);

$list = $qb->orderBy('created_at', 'desc')->get();

$out = [];
foreach($list as $b){
    $out[] = [
        'id' => $b->id,
        'booking_id' => 'BK' . str_pad($b->id, 6, '0', STR_PAD_LEFT),
        'service' => $b->service,
        'length' => $b->length,
        'base_price' => $b->base_price,
        'length_adjustment' => $b->length_adjustment,
        'final_price' => $b->final_price,
        'email' => $b->email,
        'created_at' => (string)$b->created_at,
    ];
}

echo json_encode($out, JSON_PRETTY_PRINT) . "\n";
