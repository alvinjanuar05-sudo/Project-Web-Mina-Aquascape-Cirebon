<?php
// auth/auth_check.php - Guard Middleware Sesi & Pembangkit Token Anti-CSRF
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION['user_id'])) {
    // Jika dipanggil oleh endpoint API JSON, kembalikan status 401 JSON
    if (strpos($_SERVER['SCRIPT_NAME'], '/modules/api/') !== false) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Sesi berakhir. Silakan login kembali.']);
        exit;
    }

    // Redirect dinamis ke auth/login.php dari kedalaman folder mana pun
    $login_path = (strpos($_SERVER['SCRIPT_NAME'], '/modules/') !== false)
        ? '../../auth/login.php'
        : 'auth/login.php';
    header("Location: " . $login_path);
    exit;
}

function verify_csrf() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';
        if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            die("Akses ditolak: Validasi CSRF Token gagal.");
        }
    }
}