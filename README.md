# Sistem Informasi Manajemen UMKM — Mina Aquascape Cirebon

Proyek Capstone Ujian Akhir Semester (UAS) Mata Kuliah **Pemrograman Web Dasar** (Semester Ganjil 2026/2027) — Program Studi Teknik Informatika, **STMIK IKMI Cirebon**.

- **Nama Mahasiswa:** Muhammad Alvin Januar
- **NIM:** 41257125
- **Dosen Pengampu:** Khaerul Anam, M.Kom
- **Studi Kasus UMKM:** Budidaya Ikan Hias & Ekosistem Aquascape (Mina Aquascape Cirebon)

---

## Video Demo & Penjelasan Aplikasi
- **URL Video Demo:** `[ISI_LINK_VIDEO_DEMO_DI_SINI]`

---

## Fitur Utama Aplikasi

### 1. Sisi Publik (`index.php`)
- **Neo-Editorial Showcase & Hero Slider:** Tampilan katalog visual komoditas ikan hias dan tanaman aquascape dengan kontrol slider interaktif.
- **Interactive DOM Gallery Filter:** Penyaringan katalog produk secara instan berdasarkan kategori (*Ikan Hias*, *Tanaman Air*, *Hardscape & Media*, *Pakan & Obat*).
- **Aquascape Setup Calculator (JS):** Kalkulator mandiri untuk menghitung kapasitas liter air akuarium, estimasi kebutuhan pasir silika (kg & biaya), daya lampu LED, serta batas populasi ikan ideal.

### 2. Sisi Pengelola / Dashboard Admin (`admin.php`)
- **Whitelist Route Protection:** Routing modular terproteksi untuk mencegah celah *Local File Inclusion (LFI)*.
- **Executive Dashboard Metrics:** Ringkasan total SKU, total unit stok fisik, valuasi nilai inventaris, peringatan stok menipis ($\le 20$), dan distribusi komoditas per kategori.
- **Manajemen Inventaris (CRUD):** Tambah komoditas baru beserta unggah foto produk, serta *inline editing* harga dan stok langsung pada tabel.
- **Real-Time Live Catalog (Fetch API AJAX):** Pencarian asinkron dengan teknik *debouncing* (350ms), filter kategori instan, dan penghapusan data asinkron via endpoint REST JSON.
- **Pertukaran Data Massal (CSV Pipeline):** Ekspor seluruh data produk ke file `.csv` dan impor massal berbasis *upsert* (`INSERT ... ON DUPLICATE KEY UPDATE`) berdasarkan Kode SKU.

### 3. Implementasi 4 Lapisan Security Hardening
1. **Isolasi Kredensial:** Pemisahan konfigurasi database ke berkas `config/env.php` dari instance koneksi PDO di `config/database.php`.
2. **Pengerasan Server Apache (`.htaccess`):** Menonaktifkan *directory listing* (`Options -Indexes`) dan memblokir akses HTTP langsung (`403 Forbidden`) ke berkas `.sql`, `.env`, `.log`, `env.php`, `database.php`, dan `auth_check.php`.
3. **Proteksi Anti-XSS & Anti-CSRF:** Sanitasi keluaran HTML menggunakan `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')` serta verifikasi token sesi acak 32-byte via `hash_equals()` pada seluruh mutasi `POST` dan request `Fetch API`.
4. **Pemadaman Galat Produksi:** Pengalihan otomatis `display_errors = 0` dan pencatatan log ke `logs/error.log` saat `APP_ENV` bernilai `'production'`.

---

## Panduan Instalasi Lokal (Laragon)
1. Letakkan folder proyek `UAS_41257125_MUHAMMADALVINJANUAR` di dalam direktori `C:\laragon\www\`.
2. Jalankan layanan **Apache** dan **MySQL** di Laragon.
3. Impor berkas `database.sql` ke MySQL melalui phpMyAdmin atau HeidiSQL untuk membuat database `db_umkm_aquascape` beserta data awalnya.
4. Sesuaikan host, port, dan kredensial database pada berkas `config/env.php` jika diperlukan.
5. Akses aplikasi melalui browser:
   - **Landing Page Publik:** `http://localhost:81/UAS_41257125_MUHAMMADALVINJANUAR/index.php`
   - **Login Admin:** `http://localhost:81/UAS_41257125_MUHAMMADALVINJANUAR/auth/login.php`

### Akun Login Demo Administrator
- **Username:** `admin`
- **Password:** `password123`