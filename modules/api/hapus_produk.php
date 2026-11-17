<?php
// modules/api/hapus_produk.php - Endpoint REST JSON Hapus Produk Asinkron (POST + Anti-CSRF)
require_once __DIR__ . '/../../auth/auth_check.php';
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan.']);
    exit;
}

// Ambil payload JSON atau FormData
$input = json_decode(file_get_contents('php://input'), true);
$id = (int)($input['id'] ?? $_POST['id'] ?? 0);
$token = $input['csrf_token'] ?? $_POST['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');

// Validasi Anti-CSRF
if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Token CSRF tidak valid.']);
    exit;
}

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'ID produk tidak valid.']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM produk_umkm WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode([
        'status'  => 'success',
        'message' => 'Komoditas berhasil dihapus secara asinkron.'
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data dari server.']);
}