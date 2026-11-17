<?php
$route_titles = [
    'dashboard'     => 'Executive Overview & Metrics',
    'produk_list'   => 'Specimen Inventory Management',
    'produk_live'   => 'Real-Time Asynchronous Catalog',
    'produk_tambah' => 'Register New Specimen',
    'produk_import' => 'CSV Data Pipeline Import',
];
$active_title = $route_titles[$_GET['page'] ?? 'dashboard'] ?? 'Dashboard';
?>
<header class="bg-white/90 backdrop-blur border-b border-zinc-200/80 px-6 sm:px-8 h-20 flex items-center justify-between">
    <div>
        <nav class="flex items-center gap-1.5 text-[11px] font-medium text-zinc-400">
            <span>Workspace</span>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-brand-orange font-semibold"><?= htmlspecialchars($active_title, ENT_QUOTES, 'UTF-8') ?></span>
        </nav>
        <h2 class="text-lg sm:text-xl font-semibold tracking-tight text-brand-ink"><?= htmlspecialchars($active_title, ENT_QUOTES, 'UTF-8') ?></h2>
    </div>

    <div class="flex items-center gap-3.5">
        <div class="text-right hidden sm:block">
            <p class="text-xs font-bold text-brand-ink">
                <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Administrator', ENT_QUOTES, 'UTF-8') ?>
            </p>
            <p class="inline-flex items-center gap-1 text-[11px] text-emerald-600 font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>Authenticated Session</span>
            </p>
        </div>
        <div class="w-10 h-10 rounded-full bg-brand-ink text-white text-xs font-bold flex items-center justify-center uppercase">
            <?= htmlspecialchars(substr($_SESSION['username'] ?? 'A', 0, 1), ENT_QUOTES, 'UTF-8') ?>
        </div>
    </div>
</header>