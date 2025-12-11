<?php
// Simulate a booking POST by creating a Request and calling the controller method directly.
// Run: php tools/simulate_booking.php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\AppointmentController;

$payload = [
    'name' => 'Precious Nwogu',
    'phone' => '+1234567890',
    'email' => 'nwoguprecious93+test@example.com',
    'service' => 'Smedium Knotless Braids',
    'service_type' => 'knotless',
    // Intentionally omit length to test validation for braid services
    //'length' => 'tailbone',
    'appointment_date' => date('Y-m-d', strtotime('+20 days')),
    'appointment_time' => '10:00',
    'message' => 'Simulated booking for testing',
];

// Build request
$request = Request::create('/book', 'POST', $payload);
// Mark as non-ajax form submission
$request->headers->set('X-Requested-With', 'XMLHttpRequest');

$controller = new AppointmentController();

try {
    $response = $controller->bookAppointment($request);
    if ($response instanceof \Illuminate\Http\JsonResponse) {
        echo "JSON Response:\n";
        echo $response->getContent() . "\n";
    } else {
        echo "Controller returned: \n";
        var_dump($response);
    }
} catch (\Throwable $e) {
    echo "Error invoking controller: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
