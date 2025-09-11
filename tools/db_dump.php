<?php
try {
    $dbPath = __DIR__ . '/../database/database.sqlite';
    if (!file_exists($dbPath)) {
        file_put_contents(__DIR__ . '/../storage/logs/db_dump_output.txt', "ERR: DB not found at $dbPath\n");
        exit(1);
    }
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== SERVICES (matching 'Jumbo' or all) ===\n";
    $stmt = $db->query("SELECT id, name, slug, base_price FROM services ORDER BY id");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $out = '';
    if (!$rows) {
        $out .= "(no services)\n";
    } else {
        foreach ($rows as $r) {
            $out .= sprintf("%d | %s | %s | %s\n", $r['id'], $r['name'], $r['slug'], $r['base_price']);
        }
    }

    $out .= "\n=== BOOKINGS (last 20) ===\n";
    $stmt = $db->query("SELECT id, service, length, final_price, sample_picture, created_at FROM bookings ORDER BY id DESC LIMIT 20");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) {
        $out .= "(no bookings)\n";
    } else {
        foreach ($rows as $r) {
            $out .= sprintf("%d | %s | %s | %s | %s | %s\n", $r['id'], $r['service'], $r['length'], $r['final_price'], $r['sample_picture'], $r['created_at']);
        }
    }

    file_put_contents(__DIR__ . '/db_dump_output.txt', $out);
} catch (Exception $e) {
    file_put_contents(__DIR__ . '/db_dump_output.txt', 'ERR: ' . $e->getMessage());
}
