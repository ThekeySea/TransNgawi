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

// 2. Load Autoload & Bootstrapping Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Paksa Laravel memakai folder storage /tmp
$app->useStoragePath('/tmp');

// 4. Override langsung Config Repository Laravel untuk mencegah driver bernilai string kosong ("")
$config = $app->make('config');

$defaults = [
    'session.driver'      => 'cookie',
    'cache.default'       => 'array',
    'logging.default'     => 'stderr',
    'database.default'    => 'pgsql',
    'queue.default'       => 'sync',
    'broadcasting.default' => 'log',
    'mail.default'        => 'log',
];

foreach ($defaults as $key => $fallback) {
    if (empty($config->get($key))) {
        $config->set($key, $fallback);
    }
}

// 5. Jalankan Aplikasi
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);