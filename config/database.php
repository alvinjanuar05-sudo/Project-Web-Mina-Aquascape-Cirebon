<?php
// config/database.php - Inisialisasi PDO & Pemadaman Galat Produksi
$config = require __DIR__ . '/env.php';

// Lapisan 3.4: Pemadaman pesan galat di server produksi
if ($config['APP_ENV'] === 'production') {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(E_ALL);
    ini_set('log_errors', '1');
    ini_set('error_log', __DIR__ . '/../logs/error.log');
} else {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

// Lapisan 3.1: Inisialisasi koneksi PDO aman (UTF-8 & Exception Mode)
$dsn = "mysql:host={$config['DB_HOST']};port={$config['DB_PORT']};dbname={$config['DB_NAME']};charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $config['DB_USER'], $config['DB_PASS'], $options);
} catch (PDOException $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    if ($config['APP_ENV'] === 'production') {
        die("Terjadi gangguan koneksi sistem. Silakan hubungi administrator.");
    } else {
        die("Koneksi Database Gagal: " . $e->getMessage());
    }
}