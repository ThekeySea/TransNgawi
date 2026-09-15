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

// 2. Hapus variabel lingkungan bernilai string kosong ("")
// Mencegah env('KEY', 'default') mengembalikan "" bukannya nilai default
foreach ([$_ENV, $_SERVER] as $envGroup) {
    foreach ($envGroup as $key => $value) {
        if ($value === '' || $value === null) {
            unset($_ENV[$key]);
            unset($_SERVER[$key]);
            putenv($key);
        }
    }
}

// 3. Pasang variabel environment wajib untuk Serverless Vercel
$requiredEnvs = [
    'VIEW_COMPILED_PATH' => '/tmp/views',
    'APP_SERVICES_CACHE' => '/tmp/cache/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/cache/packages.php',
    'APP_CONFIG_CACHE'   => '/tmp/cache/config.php',
    'APP_ROUTES_CACHE'   => '/tmp/cache/routes.php',
    'SESSION_DRIVER'     => 'cookie',
    'CACHE_STORE'        => 'array',
    'LOG_CHANNEL'        => 'stderr',
    'DB_CONNECTION'      => 'pgsql',
];

foreach ($requiredEnvs as $key => $value) {
    if (empty($_ENV[$key]) && empty($_SERVER[$key])) {
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
        putenv("{$key}={$value}");
    }
}

// 4. Load Autoload & Bootstrapping Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 5. Paksa Laravel memakai folder storage /tmp
$app->useStoragePath('/tmp');

// 6. Jalankan Aplikasi
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);