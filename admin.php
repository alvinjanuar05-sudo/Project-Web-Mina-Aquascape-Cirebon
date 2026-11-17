<?php
// admin.php - Controller Router Utama Dashboard (Whitelist Route Protection)
require_once __DIR__ . '/auth/auth_check.php';
require_once __DIR__ . '/config/database.php';

// Whitelist rute yang diizinkan (mencegah serangan Local File Inclusion / LFI)
$allowed_routes = [
    'dashboard'        => 'modules/dashboard/index.php',
    'produk_list'      => 'modules/produk/list.php',
    'produk_live'      => 'modules/produk/live_list.php',
    'produk_tambah'    => 'modules/produk/tambah.php',
    'produk_import'    => 'modules/produk/import.php',
];

$page = $_GET['page'] ?? 'dashboard';

if (!array_key_exists($page, $allowed_routes)) {
    $page = 'dashboard';
}

$module_path = __DIR__ . '/' . $allowed_routes[$page];

// Render kerangka antarmuka modular
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/layouts/sidebar.php';
?>

<div class="flex-1 flex flex-col min-w-0">
    <?php require_once __DIR__ . '/layouts/topbar.php'; ?>
    
    <main class="flex-1 p-6">
        <?php
        if (file_exists($module_path)) {
            require_once $module_path;
        } else {
            echo '<div class="bg-red-100 text-red-700 p-4 rounded-lg">Modul tidak ditemukan.</div>';
        }
        ?>
    </main>

    <?php require_once __DIR__ . '/layouts/footer.php'; ?>
</div>