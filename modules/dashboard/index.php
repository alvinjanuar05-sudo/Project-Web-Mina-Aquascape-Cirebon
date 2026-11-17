<?php
$stmt_total = $pdo->query("SELECT COUNT(*) as total_produk, COALESCE(SUM(stok), 0) as total_stok, COALESCE(SUM(harga * stok), 0) as nilai_aset FROM produk_umkm");
$stats = $stmt_total->fetch();

$stmt_kritis = $pdo->query("SELECT COUNT(*) FROM produk_umkm WHERE stok <= 20");
$stok_menipis = $stmt_kritis->fetchColumn();

$stmt_kategori = $pdo->query("SELECT kategori, COUNT(*) as jumlah, SUM(stok) as total_unit FROM produk_umkm GROUP BY kategori");
$per_kategori = $stmt_kategori->fetchAll();

$stmt_terbaru = $pdo->query("SELECT kode_produk, nama_produk, kategori, harga, stok, satuan FROM produk_umkm ORDER BY id DESC LIMIT 5");
$produk_terbaru = $stmt_terbaru->fetchAll();
?>

<!-- Pastel Bento Metric Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-brand-cream p-6 rounded-[2rem] flex flex-col justify-between min-h-[155px]">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold text-zinc-600">Total Specimens</span>
            <span class="w-8 h-8 rounded-full bg-brand-ink text-white flex items-center justify-center">
                <i data-lucide="layers" class="w-4 h-4"></i>
            </span>
        </div>
        <p class="text-3xl font-bold tracking-tight text-brand-ink mt-4"><?= number_format($stats['total_produk']) ?> <span class="text-xs font-medium text-zinc-500">SKU</span></p>
    </div>

    <div class="bg-brand-sky p-6 rounded-[2rem] flex flex-col justify-between min-h-[155px]">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold text-zinc-600">Physical Stock</span>
            <span class="w-8 h-8 rounded-full bg-brand-ink text-white flex items-center justify-center">
                <i data-lucide="package" class="w-4 h-4"></i>
            </span>
        </div>
        <p class="text-3xl font-bold tracking-tight text-brand-ink mt-4"><?= number_format($stats['total_stok']) ?> <span class="text-xs font-medium text-zinc-500">Units</span></p>
    </div>

    <div class="bg-brand-orange text-white p-6 rounded-[2rem] flex flex-col justify-between min-h-[155px]">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold text-white/85">Inventory Valuation</span>
            <span class="w-8 h-8 rounded-full bg-white/20 text-white flex items-center justify-center">
                <i data-lucide="wallet" class="w-4 h-4"></i>
            </span>
        </div>
        <p class="text-2xl font-bold tracking-tight mt-4">Rp <?= number_format($stats['nilai_aset'], 0, ',', '.') ?></p>
    </div>

    <div class="bg-brand-peach p-6 rounded-[2rem] flex flex-col justify-between min-h-[155px]">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold text-zinc-600">Low Stock Alert (&le;20)</span>
            <span class="w-8 h-8 rounded-full bg-brand-ink text-white flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
            </span>
        </div>
        <p class="text-3xl font-bold tracking-tight text-brand-ink mt-4"><?= number_format($stok_menipis) ?> <span class="text-xs font-medium text-zinc-500">Items</span></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Category Distribution -->
    <div class="lg:col-span-4 bg-white p-7 rounded-[2rem] border border-zinc-100">
        <h3 class="font-bold text-base tracking-tight text-brand-ink mb-5">Category Distribution</h3>
        <div class="space-y-3">
            <?php foreach ($per_kategori as $kat): ?>
                <div class="flex items-center justify-between bg-brand-surface px-4 py-3.5 rounded-2xl">
                    <div>
                        <p class="font-semibold text-xs text-brand-ink"><?= htmlspecialchars($kat['kategori'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="text-[11px] text-zinc-400 mt-0.5"><?= (int)$kat['jumlah'] ?> registered SKUs</p>
                    </div>
                    <span class="px-3 py-1 bg-white text-brand-ink text-xs font-bold rounded-full shadow-2xs">
                        <?= number_format($kat['total_unit']) ?> units
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Latest Specimens -->
    <div class="lg:col-span-8 bg-white p-7 rounded-[2rem] border border-zinc-100">
        <div class="flex justify-between items-center mb-5">
            <h3 class="font-bold text-base tracking-tight text-brand-ink">Recent Specimens</h3>
            <a href="admin.php?page=produk_list" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-orange hover:underline">
                <span>Manage All</span>
                <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="text-zinc-400 uppercase border-b border-zinc-100">
                    <tr>
                        <th class="py-3 px-3">SKU</th>
                        <th class="py-3 px-3">Specimen</th>
                        <th class="py-3 px-3">Category</th>
                        <th class="py-3 px-3 text-right">Price</th>
                        <th class="py-3 px-3 text-right">Stock</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    <?php foreach ($produk_terbaru as $item): ?>
                        <tr class="hover:bg-brand-surface/60 transition">
                            <td class="py-3.5 px-3 font-mono text-zinc-500"><?= htmlspecialchars($item['kode_produk'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="py-3.5 px-3 font-semibold text-brand-ink"><?= htmlspecialchars($item['nama_produk'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="py-3.5 px-3 text-zinc-500"><?= htmlspecialchars($item['kategori'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="py-3.5 px-3 text-right font-semibold">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td class="py-3.5 px-3 text-right font-bold text-brand-ink"><?= (int)$item['stok'] ?> <?= htmlspecialchars($item['satuan'], ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>