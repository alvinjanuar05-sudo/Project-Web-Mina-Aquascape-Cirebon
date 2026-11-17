CREATE DATABASE IF NOT EXISTS `db_umkm_aquascape` 
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `db_umkm_aquascape`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`nama_lengkap`, `username`, `password`) VALUES
('Admin Mina Aquascape', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

DROP TABLE IF EXISTS `produk_umkm`;
CREATE TABLE `produk_umkm` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_produk` VARCHAR(20) NOT NULL UNIQUE,
  `nama_produk` VARCHAR(120) NOT NULL,
  `kategori` ENUM('Ikan Hias', 'Tanaman Air', 'Hardscape & Media', 'Pakan & Obat') NOT NULL,
  `harga` INT(11) UNSIGNED NOT NULL,
  `stok` INT(11) UNSIGNED NOT NULL DEFAULT 0,
  `satuan` VARCHAR(30) NOT NULL,
  `gambar` VARCHAR(255) DEFAULT 'default.jpg',
  `deskripsi` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `produk_umkm` (`kode_produk`, `nama_produk`, `kategori`, `harga`, `stok`, `satuan`, `gambar`, `deskripsi`) VALUES
('IKN-001', 'Cupang Halfmoon Super Red', 'Ikan Hias', 45000, 35, 'Ekor', 'cupang-red.jpg', 'Cupang kontes ekor lebar 180 derajat, warna merah solid sehat dan aktif.'),
('IKN-002', 'Neon Tetra Grade A', 'Ikan Hias', 3500, 250, 'Ekor', 'neon-tetra.jpg', 'Ikan schooling ikonik untuk aquascape, warna biru neon menyala.'),
('IKN-003', 'Guppy Albino Full Red (AFR)', 'Ikan Hias', 30000, 40, 'Pasang', 'guppy-afr.jpg', 'Indukan guppy mata merah kualitas budidaya lokal Cirebon.'),
('IKN-004', 'Koi Kohaku Blitar 15cm', 'Ikan Hias', 85000, 20, 'Ekor', 'koi-kohaku.jpg', 'Pola merah putih bersih, cocok untuk kolam taman minimalis.'),
('TNM-001', 'Anubias Nana Petite', 'Tanaman Air', 25000, 60, 'Pot', 'anubias.jpg', 'Tanaman low-light tahan banting tanpa perlu injeksi CO2 tambahan.'),
('TNM-002', 'Java Moss (Vesicularia)', 'Tanaman Air', 15000, 80, 'Cup', 'java-moss.jpg', 'Lumut air untuk tempelan kayu rasamala atau batu tema natural.'),
('HRD-001', 'Pasir Silika Putih Halus', 'Hardscape & Media', 12000, 150, 'Kg', 'pasir-silika.jpg', 'Substrat dasar bersih sudah dicuci, tidak menaikkan pH air.'),
('PKN-001', 'Pelet Mikro Premium Spirulina', 'Pakan & Obat', 18000, 95, 'Botol', 'pelet-mikro.jpg', 'Pakan harian protein tinggi mencerahkan warna ikan tanpa mengeruhkan air.');