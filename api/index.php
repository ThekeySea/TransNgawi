<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// 1. Buat direktori sementara di Vercel (/tmp) jika belum ada
$dirs = [
    '/tmp/views',
    '/tmp/cache',
    '/tmp/sessions',
    '/tmp/logs',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// 2. Pasang nilai bawaan (fallback) agar driver tidak bernilai kosong/null
$defaultEnvs = [
    'VIEW_COMPILED_PATH' => '/tmp/views',
    'APP_SERVICES_CACHE' => '/tmp/cache/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/cache/packages.php',
    'APP_CONFIG_CACHE' => '/tmp/cache/config.php',
    'APP_ROUTES_CACHE' => '/tmp/cache/routes.php',
    'SESSION_DRIVER' => 'cookie',
    'CACHE_STORE' => 'array',
    'LOG_CHANNEL' => 'stderr',
    'BROADCAST_CONNECTION' => 'log',
    'QUEUE_CONNECTION' => 'sync',
    'MAIL_MAILER' => 'log',
];

foreach ($defaultEnvs as $key => $value) {
    if (empty(getenv($key))) {
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// 3. Load Autoload & Bootstrapping Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Paksa Laravel memakai folder storage /tmp
$app->useStoragePath('/tmp');

// 5. Jalankan Aplikasi
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);