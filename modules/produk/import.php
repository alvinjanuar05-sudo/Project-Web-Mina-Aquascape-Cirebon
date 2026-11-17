<?php
$hasil = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    if (isset($_FILES['file_csv']) && $_FILES['file_csv']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['file_csv']['name'], PATHINFO_EXTENSION));
        if ($ext !== 'csv') {
            $error = "Berkas harus berformat .csv!";
        } else {
            $handle = fopen($_FILES['file_csv']['tmp_name'], 'r');
            $header = fgetcsv($handle);
            $berhasil = 0;

            $sql = "INSERT INTO produk_umkm (kode_produk, nama_produk, kategori, harga, stok, satuan, deskripsi) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE 
                    nama_produk = VALUES(nama_produk),
                    kategori = VALUES(kategori),
                    harga = VALUES(harga),
                    stok = VALUES(stok),
                    satuan = VALUES(satuan),
                    deskripsi = VALUES(deskripsi)";
            $stmt = $pdo->prepare($sql);

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if (count($data) >= 6 && !empty(trim($data[0]))) {
                    $kode      = strtoupper(trim($data[0]));
                    $nama      = trim($data[1]);
                    $kategori  = in_array(trim($data[2]), ['Ikan Hias', 'Tanaman Air', 'Hardscape & Media', 'Pakan & Obat']) ? trim($data[2]) : 'Ikan Hias';
                    $harga     = (int)$data[3];
                    $stok      = (int)$data[4];
                    $satuan    = trim($data[5]);
                    $deskripsi = trim($data[6] ?? '');

                    $stmt->execute([$kode, $nama, $kategori, $harga, $stok, $satuan, $deskripsi]);
                    $berhasil++;
                }
            }
            fclose($handle);
            $hasil = "Pipeline selesai: {$berhasil} baris data komoditas berhasil diimpor / diperbarui.";
        }
    } else {
        $error = "Silakan pilih berkas CSV terlebih dahulu.";
    }
}
?>

<div class="max-w-2xl bg-white rounded-[2rem] border border-zinc-100 p-7 sm:p-9">
    <h3 class="font-bold text-lg text-brand-ink">Batch CSV Data Import</h3>
    <p class="text-xs text-zinc-500 mt-1 mb-6">Unggah berkas CSV untuk menambahkan komoditas baru atau memperbarui stok dan harga berdasarkan Kode SKU.</p>

    <?php if ($hasil): ?>
        <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl mb-5 text-xs font-semibold">
            <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
            <span><?= htmlspecialchars($hasil, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-5 text-xs font-medium">
            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
            <span><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-brand-surface rounded-2xl p-5 mb-6 text-xs text-zinc-600 space-y-2">
        <p class="font-bold text-brand-ink">Format Struktur Kolom CSV:</p>
        <code class="block bg-white px-3.5 py-2.5 rounded-xl border border-zinc-200/70 text-brand-orange font-mono text-[11px]">
            kode_produk,nama_produk,kategori,harga,stok,satuan,deskripsi
        </code>
        <p class="text-[11px] text-zinc-500">
            Unduh <a href="modules/produk/export.php" class="text-brand-ink font-bold underline">Export CSV Sheet</a> terlebih dahulu untuk memperoleh template siap pakai.
        </p>
    </div>

    <form method="POST" enctype="multipart/form-data" class="space-y-5">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
        <div>
            <label class="block text-xs font-semibold text-zinc-700 mb-2">Pilih Berkas CSV *</label>
            <input type="file" name="file_csv" accept=".csv" required class="w-full text-xs text-zinc-600 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-brand-ink file:text-white hover:file:bg-brand-orange file:transition">
        </div>
        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-brand-ink hover:bg-brand-orange text-white text-xs font-bold uppercase tracking-wider transition">
            <i data-lucide="upload-cloud" class="w-4 h-4"></i>
            <span>Execute CSV Pipeline</span>
        </button>
    </form>
</div>