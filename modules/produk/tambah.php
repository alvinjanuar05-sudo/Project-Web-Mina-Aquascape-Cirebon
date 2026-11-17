<?php
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $kode      = strtoupper(trim($_POST['kode_produk'] ?? ''));
    $nama      = trim($_POST['nama_produk'] ?? '');
    $kategori  = $_POST['kategori'] ?? 'Ikan Hias';
    $harga     = (int)($_POST['harga'] ?? 0);
    $stok      = (int)($_POST['stok'] ?? 0);
    $satuan    = trim($_POST['satuan'] ?? 'Ekor');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $gambar    = 'default.jpg';

    if (!empty($_FILES['gambar']['name'])) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($ext, $allowed_ext) && $_FILES['gambar']['size'] <= 2 * 1024 * 1024) {
            $gambar = uniqid('prod_') . '.' . $ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], __DIR__ . '/../../assets/img/' . $gambar);
        } else {
            $error = "Format gambar harus JPG/PNG/WEBP dan maksimal 2MB.";
        }
    }

    if (!$error) {
        try {
            $stmt = $pdo->prepare("INSERT INTO produk_umkm (kode_produk, nama_produk, kategori, harga, stok, satuan, gambar, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$kode, $nama, $kategori, $harga, $stok, $satuan, $gambar, $deskripsi]);
            header("Location: admin.php?page=produk_list&sukses=1");
            exit;
        } catch (PDOException $e) {
            $error = "Gagal menyimpan: Kode SKU sudah terdaftar atau data tidak valid.";
        }
    }
}
?>

<div class="max-w-2xl bg-white rounded-[2rem] border border-zinc-100 p-7 sm:p-9">
    <h3 class="font-bold text-lg text-brand-ink">Register New Specimen</h3>
    <p class="text-xs text-zinc-500 mt-1 mb-7">Tambahkan komoditas ikan hias, tanaman air, atau media aquascape ke inventaris.</p>

    <?php if ($error): ?>
        <div class="flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-5 text-xs font-medium">
            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
            <span><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Kode Produk (SKU) *</label>
                <input type="text" name="kode_produk" required placeholder="Contoh: IKN-005" class="w-full px-4 py-2.5 rounded-2xl bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink text-sm outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Kategori *</label>
                <select name="kategori" class="w-full px-4 py-2.5 rounded-2xl bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink text-sm outline-none transition">
                    <option value="Ikan Hias">Ikan Hias</option>
                    <option value="Tanaman Air">Tanaman Air</option>
                    <option value="Hardscape & Media">Hardscape &amp; Media</option>
                    <option value="Pakan & Obat">Pakan &amp; Obat</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Nama Komoditas *</label>
            <input type="text" name="nama_produk" required placeholder="Contoh: Cardinal Tetra Size M" class="w-full px-4 py-2.5 rounded-2xl bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink text-sm outline-none transition">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Harga Satuan (Rp) *</label>
                <input type="number" name="harga" required min="0" placeholder="15000" class="w-full px-4 py-2.5 rounded-2xl bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink text-sm outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Stok Awal *</label>
                <input type="number" name="stok" required min="0" placeholder="50" class="w-full px-4 py-2.5 rounded-2xl bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink text-sm outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Satuan *</label>
                <input type="text" name="satuan" required value="Ekor" placeholder="Ekor / Pot / Kg" class="w-full px-4 py-2.5 rounded-2xl bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink text-sm outline-none transition">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Foto Produk (Opsional, JPG/PNG/WEBP)</label>
            <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp" class="w-full text-xs text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-brand-ink file:text-white hover:file:bg-brand-orange file:transition">
        </div>

        <div>
            <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Deskripsi Singkat</label>
            <textarea name="deskripsi" rows="3" placeholder="Karakteristik ikan/tanaman, parameter air, dll." class="w-full px-4 py-2.5 rounded-2xl bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink text-sm outline-none transition"></textarea>
        </div>

        <div class="pt-3 flex items-center gap-3">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-brand-ink hover:bg-brand-orange text-white text-xs font-bold uppercase tracking-wider transition">
                <span>Save Specimen</span>
                <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
            </button>
            <a href="admin.php?page=produk_list" class="px-5 py-3 rounded-full bg-brand-surface hover:bg-zinc-200 text-zinc-700 text-xs font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>