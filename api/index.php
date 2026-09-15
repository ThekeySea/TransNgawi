<?php

// Tampilkan semua error PHP langsung ke layar browser
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Buat direktori sementara di /tmp jika belum ada
$dirs = ['/tmp/views', '/tmp/cache', '/tmp/sessions'];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

require __DIR__ . '/../public/index.php';