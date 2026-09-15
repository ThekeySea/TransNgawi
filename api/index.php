<?php

// Buat folder /tmp/views hanya jika belum ada
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

require __DIR__ . '/../public/index.php';