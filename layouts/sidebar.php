<?php
$current_page = $_GET['page'] ?? 'dashboard';
function isActive($route, $current) {
    return $route === $current 
        ? 'bg-brand-ink text-white shadow-xs' 
        : 'text-zinc-600 hover:bg-brand-surface hover:text-brand-ink';
}
?>
<aside class="w-68 bg-white border-r border-zinc-200/80 flex-shrink-0 hidden md:flex flex-col justify-between">
    <div>
        <!-- Brand Monogram Header -->
        <div class="h-20 px-6 border-b border-zinc-100 flex items-center justify-between">
            <a href="admin.php?page=dashboard" class="flex items-center gap-3">
                <svg class="w-7 h-7 text-brand-ink" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 8L13 28H17L11 14L18 28L25 14L19 28H23L32 8H26.5L18 24L9.5 8H4Z" fill="currentColor"/>
                </svg>
                <div>
                    <h1 class="font-bold text-sm tracking-tight text-brand-ink uppercase">Mina Aquascape</h1>
                    <p class="text-[11px] text-zinc-400">Operator Workspace</p>
                </div>
            </a>
        </div>

        <nav class="p-4 space-y-1 text-xs font-semibold">
            <p class="px-3 pt-2 pb-1 text-[10px] font-bold text-zinc-400 uppercase tracking-widest">Overview</p>
            
            <a href="admin.php?page=dashboard" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl transition <?= isActive('dashboard', $current_page) ?>">
                <i data-lucide="layout-grid" class="w-4 h-4"></i>
                <span>Dashboard Metrics</span>
            </a>

            <p class="px-3 pt-5 pb-1 text-[10px] font-bold text-zinc-400 uppercase tracking-widest">Inventory Management</p>

            <a href="admin.php?page=produk_list" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl transition <?= isActive('produk_list', $current_page) ?>">
                <i data-lucide="database" class="w-4 h-4"></i>
                <span>Catalog &amp; Stock (CRUD)</span>
            </a>

            <a href="admin.php?page=produk_live" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl transition <?= isActive('produk_live', $current_page) ?>">
                <i data-lucide="search" class="w-4 h-4"></i>
                <span>Live Catalog (AJAX)</span>
            </a>

            <a href="admin.php?page=produk_tambah" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl transition <?= isActive('produk_tambah', $current_page) ?>">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Add New Specimen</span>
            </a>

            <p class="px-3 pt-5 pb-1 text-[10px] font-bold text-zinc-400 uppercase tracking-widest">Data Pipeline</p>

            <a href="admin.php?page=produk_import" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl transition <?= isActive('produk_import', $current_page) ?>">
                <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                <span>Import CSV Batch</span>
            </a>

            <a href="modules/produk/export.php" class="flex items-center gap-3 px-3.5 py-3 rounded-2xl text-zinc-600 hover:bg-brand-surface hover:text-brand-ink transition">
                <i data-lucide="download-cloud" class="w-4 h-4"></i>
                <span>Export CSV Sheet</span>
            </a>
        </nav>
    </div>

    <div class="p-4 border-t border-zinc-100 space-y-2 text-xs font-semibold">
        <a href="index.php" target="_blank" class="flex items-center justify-between py-2.5 px-4 rounded-2xl bg-brand-surface hover:bg-zinc-200/80 text-brand-ink transition">
            <span>Public Showcase</span>
            <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
        </a>
        <a href="auth/logout.php" class="flex items-center justify-between py-2.5 px-4 rounded-2xl bg-red-50 hover:bg-red-600 text-red-600 hover:text-white transition">
            <span>Sign Out</span>
            <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
        </a>
    </div>
</aside>