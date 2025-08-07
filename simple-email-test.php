<?php

echo "Testing Email Notification Classes Syntax\n";
echo "=========================================\n\n";

// Test syntax of BookingConfirmation
echo "1. Testing BookingConfirmation.php syntax...\n";
$output = shell_exec('php -l app/Notifications/BookingConfirmation.php 2>&1');
if (strpos($output, 'No syntax errors') !== false) {
    echo "✓ BookingConfirmation.php - No syntax errors\n";
} else {
    echo "✗ BookingConfirmation.php - Syntax error:\n";
    echo $output . "\n";
}

echo "\n2. Testing AdminBookingNotification.php syntax...\n";
$output = shell_exec('php -l app/Notifications/AdminBookingNotification.php 2>&1');
if (strpos($output, 'No syntax errors') !== false) {
    echo "✓ AdminBookingNotification.php - No syntax errors\n";
} else {
    echo "✗ AdminBookingNotification.php - Syntax error:\n";
    echo $output . "\n";
}

echo "\n3. Testing AppointmentController.php syntax...\n";
$output = shell_exec('php -l app/Http/Controllers/AppointmentController.php 2>&1');
if (strpos($output, 'No syntax errors') !== false) {
    echo "✓ AppointmentController.php - No syntax errors\n";
} else {
    echo "✗ AppointmentController.php - Syntax error:\n";
    echo $output . "\n";
}

echo "\n4. Checking .env configuration...\n";
if (file_exists('.env')) {
    echo "✓ .env file exists\n";
    
    $envContent = file_get_contents('.env');
    if (strpos($envContent, 'MAIL_MAILER=log') !== false) {
        echo "✓ Mail driver set to 'log' for testing\n";
    } elseif (strpos($envContent, 'MAIL_MAILER=smtp') !== false) {
        echo "✓ Mail driver set to 'smtp'\n";
    } else {
        echo "⚠ Mail driver not clearly set\n";
    }
    
    if (strpos($envContent, 'MAIL_FROM_ADDRESS') !== false) {
        echo "✓ MAIL_FROM_ADDRESS is configured\n";
    } else {
        echo "⚠ MAIL_FROM_ADDRESS not set\n";
    }
} else {
    echo "✗ .env file not found\n";
}

echo "\n5. Checking Laravel log for email errors...\n";
if (file_exists('storage/logs/laravel.log')) {
    $logContent = file_get_contents('storage/logs/laravel.log');
    $recentLogs = explode("\n", $logContent);
    $recentLogs = array_slice($recentLogs, -20); // Get last 20 lines
    
    $emailErrors = array_filter($recentLogs, function($line) {
        return strpos($line, 'mail') !== false || 
               strpos($line, 'email') !== false || 
               strpos($line, 'notification') !== false ||
               strpos($line, 'ERROR') !== false;
    });
    
    if (empty($emailErrors)) {
        echo "✓ No recent email-related errors in log\n";
    } else {
        echo "⚠ Recent email-related log entries:\n";
        foreach (array_slice($emailErrors, -5) as $error) {
            echo "  " . trim($error) . "\n";
        }
    }
} else {
    echo "✗ Laravel log file not found\n";
}

echo "\n6. Summary\n";
echo "=========\n";
echo "If syntax checks pass but emails still don't work, try:\n";
echo "- Check if Laravel server is running (php artisan serve)\n";
echo "- Test booking form on the website\n";
echo "- Check storage/logs/laravel.log after making a booking\n";
echo "- Verify email appears in storage/logs/laravel.log (if using log driver)\n";

echo "\nTest completed.\n";
