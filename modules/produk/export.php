<?php
// modules/produk/export.php - Ekspor Data Produk ke File CSV
require_once __DIR__ . '/../../auth/auth_check.php';
require_once __DIR__ . '/../../config/database.php';

$filename = "inventaris_mina_aquascape_" . date('Ymd_His') . ".csv";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');

// Header kolom CSV
fputcsv($output, ['kode_produk', 'nama_produk', 'kategori', 'harga', 'stok', 'satuan', 'deskripsi']);

$stmt = $pdo->query("SELECT kode_produk, nama_produk, kategori, harga, stok, satuan, deskripsi FROM produk_umkm ORDER BY id ASC");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
exit;