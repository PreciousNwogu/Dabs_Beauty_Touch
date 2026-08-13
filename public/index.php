<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

$uploadTmp = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'tmp';
if (!is_dir($uploadTmp)) {
    @mkdir($uploadTmp, 0775, true);
}
if (is_dir($uploadTmp)) {
    $uploadTmp = realpath($uploadTmp) ?: $uploadTmp;
    putenv('TMP=' . $uploadTmp);
    putenv('TEMP=' . $uploadTmp);
    putenv('TMPDIR=' . $uploadTmp);
    $_ENV['TMP'] = $uploadTmp;
    $_ENV['TEMP'] = $uploadTmp;
    $_ENV['TMPDIR'] = $uploadTmp;
}

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
