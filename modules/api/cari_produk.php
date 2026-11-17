<?php
// modules/api/cari_produk.php - Endpoint REST JSON untuk Live Search Asinkron
require_once __DIR__ . '/../../auth/auth_check.php';
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json; charset=utf-8');

$keyword  = trim($_GET['q'] ?? '');
$kategori = trim($_GET['kategori'] ?? '');

$sql = "SELECT id, kode_produk, nama_produk, kategori, harga, stok, satuan, deskripsi FROM produk_umkm WHERE 1=1";
$params = [];

if ($keyword !== '') {
    $sql .= " AND (nama_produk LIKE ? OR kode_produk LIKE ? OR deskripsi LIKE ?)";
    $like = "%{$keyword}%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}

if ($kategori !== '') {
    $sql .= " AND kategori = ?";
    $params[] = $kategori;
}

$sql .= " ORDER BY id DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $data = $stmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'total'  => count($data),
        'data'   => $data
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Gagal mengambil data produk.'
    ]);
}