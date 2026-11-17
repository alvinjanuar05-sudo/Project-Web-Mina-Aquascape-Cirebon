<?php
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $aksi = $_POST['aksi'] ?? '';

    if ($aksi === 'hapus') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("DELETE FROM produk_umkm WHERE id = ?");
        $stmt->execute([$id]);
        $pesan = "Komoditas berhasil dihapus dari inventaris.";
    } elseif ($aksi === 'update_stok') {
        $id = (int)($_POST['id'] ?? 0);
        $stok_baru = max(0, (int)($_POST['stok'] ?? 0));
        $harga_baru = max(0, (int)($_POST['harga'] ?? 0));
        $stmt = $pdo->prepare("UPDATE produk_umkm SET stok = ?, harga = ? WHERE id = ?");
        $stmt->execute([$stok_baru, $harga_baru, $id]);
        $pesan = "Harga dan stok komoditas berhasil diperbarui.";
    }
}

$stmt = $pdo->query("SELECT * FROM produk_umkm ORDER BY id DESC");
$produk_list = $stmt->fetchAll();
?>

<?php if ($pesan || isset($_GET['sukses'])): ?>
    <div class="flex items-center gap-2.5 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-2xl mb-6 text-xs font-semibold">
        <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
        <span><?= htmlspecialchars($pesan ?: 'Data komoditas baru berhasil disimpan!', ENT_QUOTES, 'UTF-8') ?></span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-[2rem] border border-zinc-100 overflow-hidden">
    <div class="p-6 sm:p-7 border-b border-zinc-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-bold text-base text-brand-ink">Specimen &amp; Inventory List</h3>
            <p class="text-xs text-zinc-500 mt-0.5">Sesuaikan harga atau jumlah stok secara langsung pada tabel.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="modules/produk/export.php" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold rounded-full bg-brand-surface hover:bg-zinc-200 text-brand-ink transition">
                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                <span>Export CSV</span>
            </a>
            <a href="admin.php?page=produk_tambah" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold rounded-full bg-brand-ink hover:bg-brand-orange text-white transition">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                <span>Add Specimen</span>
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-brand-surface text-zinc-500 uppercase">
                <tr>
                    <th class="py-3.5 px-5">SKU</th>
                    <th class="py-3.5 px-5">Specimen Details</th>
                    <th class="py-3.5 px-5">Category</th>
                    <th class="py-3.5 px-5">Unit Price (Rp)</th>
                    <th class="py-3.5 px-5">Stock</th>
                    <th class="py-3.5 px-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                <?php foreach ($produk_list as $row): ?>
                    <tr class="hover:bg-brand-surface/50 transition">
                        <td class="py-4 px-5 font-mono text-zinc-500">
                            <?= htmlspecialchars($row['kode_produk'], ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td class="py-4 px-5">
                            <p class="font-bold text-brand-ink text-sm"><?= htmlspecialchars($row['nama_produk'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="text-[11px] text-zinc-400 truncate max-w-xs mt-0.5"><?= htmlspecialchars($row['deskripsi'], ENT_QUOTES, 'UTF-8') ?></p>
                        </td>
                        <td class="py-4 px-5">
                            <span class="px-3 py-1 text-[11px] font-semibold rounded-full bg-brand-surface text-zinc-700">
                                <?= htmlspecialchars($row['kategori'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <form method="POST" class="flex items-center gap-2">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="aksi" value="update_stok">
                                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                <input type="number" name="harga" value="<?= (int)$row['harga'] ?>" class="w-28 px-3 py-1.5 text-xs font-semibold bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink rounded-xl outline-none">
                        </td>
                        <td class="py-4 px-5">
                                <div class="flex items-center gap-2">
                                    <input type="number" name="stok" value="<?= (int)$row['stok'] ?>" class="w-16 px-2.5 py-1.5 text-xs font-semibold bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink rounded-xl outline-none">
                                    <span class="text-[11px] text-zinc-500"><?= htmlspecialchars($row['satuan'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                        </td>
                        <td class="py-4 px-5 text-right space-x-1.5 whitespace-nowrap">
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-[11px] font-semibold bg-brand-ink hover:bg-brand-orange text-white rounded-full transition">
                                    <i data-lucide="check" class="w-3 h-3"></i>
                                    <span>Save</span>
                                </button>
                            </form>
                            <form method="POST" class="inline" onsubmit="return confirm('Hapus komoditas ini dari database?')">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="aksi" value="hapus">
                                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-[11px] font-semibold bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-full transition">
                                    <i data-lucide="trash-2" class="w-3 h-3"></i>
                                    <span>Delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>