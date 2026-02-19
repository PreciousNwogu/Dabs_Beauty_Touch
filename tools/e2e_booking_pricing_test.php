<?php
/**
 * End-to-end pricing verification for /bookings route.
 *
 * This script dispatches POST /bookings through the route closure (bypassing CSRF middleware),
 * then verifies:
 *  - the persisted booking.final_price matches expected server-calculated values
 *  - the rendered customer/admin email templates contain that final price
 *
 * Run: php tools/e2e_booking_pricing_test.php
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Models\Booking;

// Force mail into log transport so we don't hit real SMTP during this test
try {
    putenv('MAIL_MAILER=log');
    $_ENV['MAIL_MAILER'] = 'log';
    $_SERVER['MAIL_MAILER'] = 'log';
} catch (\Throwable $e) {}
try {
    config([
        'mail.default' => 'log',
        'mail.admin_address' => 'admin-test@example.com',
        'mail.mailers.log' => ['transport' => 'log'],
    ]);
} catch (\Throwable $e) {}

function dispatchBookingsPost(array $payload): array
{
    $request = Request::create('/bookings', 'POST', $payload);
    $request->headers->set('X-Requested-With', 'XMLHttpRequest');
    $request->headers->set('Accept', 'application/json');

    // Ensure the container/global request is this request so route injection/validation reads our payload
    try {
        app()->instance('request', $request);
        \Illuminate\Support\Facades\Facade::clearResolvedInstance('request');
    } catch (\Throwable $e) {}

    $router = app('router');
    $route = $router->getRoutes()->match($request);
    $response = $route->run(); // bypass middleware pipeline (CSRF)

    if ($response instanceof \Illuminate\Http\JsonResponse) {
        $data = json_decode($response->getContent(), true);
        if (!is_array($data)) {
            throw new RuntimeException('Unexpected JSON response: ' . $response->getContent());
        }
        return $data;
    }

    if ($response instanceof \Illuminate\Http\Response) {
        throw new RuntimeException('Unexpected non-JSON response: HTTP ' . $response->getStatusCode());
    }

    throw new RuntimeException('Unexpected response type: ' . get_class($response));
}

function renderMailView(\Illuminate\Notifications\Messages\MailMessage $mail): string
{
    // MailMessage typically stores these as public properties
    $view = $mail->view ?? null;
    $data = $mail->viewData ?? [];
    if (!$view) {
        throw new RuntimeException('MailMessage missing view');
    }
    return view($view, $data)->render();
}

function makeNotifiable(string $email): object
{
    return new class($email) {
        public string $email;
        public function __construct(string $email) { $this->email = $email; }
        public function routeNotificationFor(string $channel) { return $this->email; }
    };
}

function assertContains(string $needle, string $haystack, string $label): void
{
    if (strpos($haystack, $needle) === false) {
        throw new RuntimeException("Assertion failed: expected '{$needle}' in {$label}");
    }
}

$todayPlus = function (int $days): string {
    return date('Y-m-d', strtotime('+' . $days . ' days'));
};

$cases = [
    [
        'name' => 'Stitch weave + tiny rows add-on',
        'payload' => [
            'name' => 'E2E Test Stitch',
            'email' => 'e2e+stitch@example.com',
            'phone' => '+15555550101',
            'appointment_type' => 'in-studio',
            'service' => 'Stitch Weave',
            'service_type' => 'stitch-weave',
            'length' => 'mid_back',
            'stitch_rows_option' => 'more_than_ten',
            'terms_accepted' => '1',
            'appointment_date' => $todayPlus(10),
            'appointment_time' => '10:00',
            'message' => 'E2E: stitch tiny rows',
        ],
        'expected_final' => 130.00, // 100 base + 30 addon
        'expected_fmt' => '$130.00',
    ],
    [
        'name' => 'Hair mask with weave add-on',
        'payload' => [
            'name' => 'E2E Test Mask',
            'email' => 'e2e+mask@example.com',
            'phone' => '+15555550102',
            'appointment_type' => 'in-studio',
            'service' => 'Natural Hair Treatment/Mask',
            'service_type' => 'natural-hair-treatment',
            'length' => 'mid_back',
            'hair_mask_option' => 'mask-with-weave',
            'terms_accepted' => '1',
            'appointment_date' => $todayPlus(11),
            'appointment_time' => '11:00',
            'message' => 'E2E: mask with weave',
        ],
        'expected_final' => 80.00, // 50 base + 30 addon
        'expected_fmt' => '$80.00',
    ],
    [
        'name' => '2/3 line single front+back add-on',
        'payload' => [
            'name' => 'E2E Test LineSingle',
            'email' => 'e2e+line@example.com',
            'phone' => '+15555550103',
            'appointment_type' => 'in-studio',
            'service' => '2/3 Line Single',
            'service_type' => 'line-single',
            'length' => 'mid_back',
            'frontback_addon' => 'yes',
            'terms_accepted' => '1',
            'appointment_date' => $todayPlus(12),
            'appointment_time' => '12:00',
            'message' => 'E2E: front+back add-on',
        ],
        'expected_final' => 120.00, // 100 base + 20 addon
        'expected_fmt' => '$120.00',
    ],
];

echo "Running E2E booking pricing tests...\n\n";

foreach ($cases as $case) {
    echo "- Case: {$case['name']}\n";
    $json = dispatchBookingsPost($case['payload']);

    $bk = $json['appointment']['booking_id'] ?? null;
    if (!is_string($bk) || !preg_match('/^BK(\d{6})$/', $bk, $m)) {
        throw new RuntimeException('Could not parse booking_id from response: ' . json_encode($json));
    }
    $id = (int) ltrim($m[1], '0');
    $booking = Booking::find($id);
    if (!$booking) {
        throw new RuntimeException("Booking not found after creation: id={$id}");
    }

    $final = (float) $booking->final_price;
    $expected = (float) $case['expected_final'];
    if (abs($final - $expected) > 0.009) {
        throw new RuntimeException("Persisted final_price mismatch. expected={$expected} got={$final} booking_id={$bk}");
    }
    echo "  persisted final_price OK: {$final}\n";

    // Render customer confirmation email view and ensure it includes the expected total
    $customerNotif = new \App\Notifications\BookingConfirmation($booking);
    $customerMail = $customerNotif->toMail(makeNotifiable($booking->email ?: 'customer@example.com'));
    $customerHtml = renderMailView($customerMail);
    assertContains($case['expected_fmt'], $customerHtml, 'customer confirmation email HTML');
    echo "  customer email contains {$case['expected_fmt']}\n";

    // Render admin booking email view and ensure it includes the expected total
    $adminNotif = new \App\Notifications\AdminBookingNotification($booking);
    $adminMail = $adminNotif->toMail(makeNotifiable('admin-test@example.com'));
    $adminHtml = renderMailView($adminMail);
    assertContains($case['expected_fmt'], $adminHtml, 'admin booking email HTML');
    echo "  admin email contains {$case['expected_fmt']}\n";

    echo "  OK ({$bk})\n\n";
}

echo "All E2E pricing tests passed.\n";

