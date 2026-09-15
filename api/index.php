<?php

// 1. Paksa PHP menampilkan semua error fatal ke browser
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// 2. Buat folder sementara di sistem Vercel (/tmp)
$dirs = ['/tmp/views', '/tmp/cache', '/tmp/sessions', '/tmp/logs'];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// 3. Paksa variabel lingkungan Laravel menggunakan folder /tmp
putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');
putenv('CACHE_STORE=array');

// 4. Panggil berkas utama Laravel
require __DIR__ . '/../public/index.php';