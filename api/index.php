<?php

// Buat direktori sementara untuk kompilasi Blade & Cache Vercel
mkdir('/tmp/views', 0755, true);

require __DIR__ . '/../public/index.php';