<?php
// booking_test.php - creates a test booking similar to the web route and writes results to tools/booking_test_result.txt
try {
    $dbPath = __DIR__ . '/../database/database.sqlite';
    if (!file_exists($dbPath)) {
        throw new Exception('DB not found at ' . $dbPath);
    }

    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ensure services table exists and seed jumbo-knotless if missing
    $tbl = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='services'")->fetch(PDO::FETCH_ASSOC);
    if (!$tbl) {
        $db->exec("CREATE TABLE services (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, slug TEXT UNIQUE, base_price REAL DEFAULT 150.00)");
    }

    // Insert jumbo-knotless if not present
    $stmt = $db->prepare("SELECT id,name,slug,base_price FROM services WHERE slug = :slug LIMIT 1");
    $stmt->execute([':slug' => 'jumbo-knotless']);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$service) {
        $ins = $db->prepare("INSERT INTO services (name,slug,base_price) VALUES (:name,:slug,:base_price)");
        $ins->execute([':name' => 'Jumbo Knotless Braids', ':slug' => 'jumbo-knotless', ':base_price' => 60.00]);
        $stmt->execute([':slug' => 'jumbo-knotless']);
        $service = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    $base = $service ? (float)$service['base_price'] : 150.00;
    $adjustments = [
        'neck' => -20.00,
        'shoulder' => -20.00,
        'armpit' => -20.00,
        'bra_strap' => -20.00,
        'mid_back' => 0.00,
        'waist' => 20.00,
        'hip' => 20.00,
        'tailbone' => 40.00,
        'thigh' => 40.00,
        'classic' => 40.00,
    ];

    $length = 'neck';
    $adjust = $adjustments[$length] ?? 0.00;
    $finalPrice = round($base + $adjust, 2);

    // Insert booking row
    $insert = $db->prepare("INSERT INTO bookings (name, email, phone, service, appointment_date, appointment_time, message, notes, sample_picture, status, length, final_price, created_at, updated_at) VALUES (:name,:email,:phone,:service,:date,:time,:message,:notes,:sample_picture,:status,:length,:final_price,:created_at,:updated_at)");
    $now = date('Y-m-d H:i:s');
    $insert->execute([
        ':name' => 'Automated Test User',
        ':email' => 'test@example.com',
        ':phone' => '0000000000',
        ':service' => $service ? $service['name'] : 'Jumbo Knotless Braids',
        ':date' => date('Y-m-d', strtotime('+3 days')),
        ':time' => '10:00',
        ':message' => 'Automated test booking',
        ':notes' => 'Automated test booking',
        ':sample_picture' => null,
        ':status' => 'pending',
        ':length' => $length,
        ':final_price' => $finalPrice,
        ':created_at' => $now,
        ':updated_at' => $now,
    ]);

    $bookingId = $db->lastInsertId();

    // Write result file with booking row and simulated email body
    $bookingRow = $db->query("SELECT id,name,service,length,final_price,confirmation_code,created_at FROM bookings WHERE id = $bookingId")->fetch(PDO::FETCH_ASSOC);

    $emailBody = "Subject: Booking Confirmation\n";
    $emailBody .= "Hello " . $bookingRow['name'] . "\n";
    $emailBody .= "Booking ID: BK" . str_pad($bookingRow['id'], 6, '0', STR_PAD_LEFT) . "\n";
    $emailBody .= "Confirmation code: " . ($bookingRow['confirmation_code'] ?? 'N/A') . "\n";
    $emailBody .= "Service: " . $bookingRow['service'] . "\n";
    $emailBody .= "Length: " . $bookingRow['length'] . "\n";
    $emailBody .= "Total price: $" . number_format($bookingRow['final_price'],2) . "\n";

    $out = "SERVICE BASE: " . $base . "\n";
    $out .= "LENGTH ADJUST: " . $adjust . "\n";
    $out .= "FINAL PRICE CALC: " . $finalPrice . "\n\n";
    $out .= "BOOKING ROW:\n" . json_encode($bookingRow) . "\n\n";
    $out .= "EMAIL:\n" . $emailBody . "\n";

    file_put_contents(__DIR__ . '/../storage/logs/booking_test_result.txt', $out);

    echo "OK\n";
} catch (Exception $e) {
    file_put_contents(__DIR__ . '/../storage/logs/booking_test_result.txt', 'ERR: ' . $e->getMessage());
    echo "ERR\n";
}
