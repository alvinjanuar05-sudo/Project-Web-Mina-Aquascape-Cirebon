<?php
// index.php - Landing Page Publik UMKM Budidaya Ikan Hias & Aquascape (Neo-Editorial Theme)
require_once __DIR__ . '/config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM produk_umkm ORDER BY id DESC");
    $katalog = $stmt->fetchAll();
} catch (PDOException $e) {
    $katalog = [];
}

// Ambil 3 produk unggulan pertama untuk section Signature Showcase
$unggulan = array_slice($katalog, 0, 3);

// Master Fallback Image (Underwater Ecosystem / Fish) - Verified HTTP 200 OK
$fallback_img = 'https://images.unsplash.com/photo-1522069169874-c58ec4b76be5?auto=format&fit=crop&w=1000&q=80';

// CDN Category Default Images (Verified HTTP 200 OK)
$cdn_images = [
    'Ikan Hias'         => 'https://images.unsplash.com/photo-1522069169874-c58ec4b76be5?auto=format&fit=crop&w=1200&q=80',
    'Tanaman Air'       => 'https://images.unsplash.com/photo-1546026423-cc4642628d2b?auto=format&fit=crop&w=1200&q=80',
    'Hardscape & Media' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&q=80',
    'Pakan & Obat'      => 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?auto=format&fit=crop&w=1200&q=80',
];

// Mapping Gambar Spesifik per Kode SKU untuk variasi visual akurat & relevan (Verified HTTP 200 OK)
$sku_images = [
    'IKN-001' => 'https://images.unsplash.com/photo-1534043464124-3be32fe000c9?auto=format&fit=crop&w=1000&q=80', // Cupang Halfmoon Red
    'IKN-002' => 'https://images.unsplash.com/photo-1535591273668-578e31182c4f?auto=format&fit=crop&w=1000&q=80', // Neon Tetra Schooling
    'IKN-003' => 'https://images.unsplash.com/photo-1520302630591-fd1c66edc19d?auto=format&fit=crop&w=1000&q=80', // Guppy Albino Full Red
    'IKN-004' => 'https://images.unsplash.com/photo-1584553421349-3557471bed79?auto=format&fit=crop&w=1000&q=80', // Koi Kohaku Blitar
    'TNM-001' => 'https://images.unsplash.com/photo-1546026423-cc4642628d2b?auto=format&fit=crop&w=1000&q=80', // Anubias Nana Petite
    'TNM-002' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1000&q=80', // Java Moss
    'HRD-001' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1000&q=80', // Pasir Silika / Hardscape
    'PKN-001' => 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?auto=format&fit=crop&w=1000&q=80', // Pelet Mikro Spirulina
];
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mina Aquascape — Budidaya Ikan Hias &amp; Ekosistem Air</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- GSAP 3 & ScrollTrigger Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            orange: '#FF5500',
                            cream: '#FDF5D3',
                            sky: '#E0ECFF',
                            peach: '#FDE9DF',
                            surface: '#F6F6F5',
                            ink: '#18181B'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-brand-ink font-sans antialiased selection:bg-brand-orange selection:text-white">

    <!-- Navbar Minimalis dengan Monogram Tengah -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-zinc-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-zinc-600">
                <a href="#beranda" class="hover:text-brand-ink transition">Home</a>
                <a href="#filosofi" class="hover:text-brand-ink transition">Philosophy</a>
                <a href="#signature" class="hover:text-brand-ink transition">Signature</a>
                <a href="#katalog" class="hover:text-brand-ink transition">Catalog</a>
            </nav>

            <!-- Monogram Brand di Tengah -->
            <a href="#beranda" class="flex items-center gap-2 group">
                <svg class="w-8 h-8 text-brand-ink transition-transform duration-300 group-hover:scale-105" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 8L13 28H17L11 14L18 28L25 14L19 28H23L32 8H26.5L18 24L9.5 8H4Z" fill="currentColor"/>
                </svg>
            </a>

            <div class="flex items-center gap-6 text-sm font-medium">
                <a href="#kalkulator" class="text-zinc-600 hover:text-brand-ink transition hidden sm:inline-flex items-center gap-1.5">
                    <span>Tank Calculator</span>
                </a>
                <a href="auth/login.php" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-ink text-white hover:bg-brand-orange transition text-xs font-semibold tracking-wide">
                    <span>Admin Portal</span>
                    <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section: Editorial Typography + Rounded Showcase Slider -->
    <section id="beranda" class="max-w-7xl mx-auto px-6 pt-12 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end mb-10">
            <div class="lg:col-span-7">
                <h1 id="hero-title" class="text-4xl sm:text-5xl lg:text-[62px] font-semibold tracking-[-0.035em] leading-[1.05] text-brand-ink uppercase">
                    WE CULTIVATE LIVING AQUASCAPES TODAY
                </h1>
            </div>
            <div class="lg:col-span-5 lg:pb-2">
                <p id="hero-desc" class="text-zinc-500 text-base leading-relaxed max-w-md">
                    Mina Aquascape menghadirkan ekosistem bawah air yang presisi dan berkelanjutan. Kami membudidayakan ikan hias pilihan serta flora air berkualitas langsung dari Cirebon.
                </p>
            </div>
        </div>

        <!-- Hero Showcase Frame dengan Slider & Floating Glass Card -->
        <div id="hero-frame" class="relative rounded-[2.25rem] overflow-hidden bg-zinc-100 h-[440px] sm:h-[540px] group shadow-xs">
            <!-- Slide 1 -->
            <div class="hero-slide absolute inset-0 transition-opacity duration-700 opacity-100">
                <img src="https://images.unsplash.com/photo-1522069169874-c58ec4b76be5?auto=format&fit=crop&w=1600&q=85"
                     alt="Budidaya Ikan Hias Premium" loading="eager"
                     onerror="this.onerror=null; this.src='https://images.pexels.com/photos/128756/pexels-photo-128756.jpeg?auto=compress&cs=tinysrgb&w=1600';"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>

                <!-- Floating Glass Card -->
                <div class="absolute bottom-8 left-8 sm:bottom-12 sm:left-12 max-w-xs bg-white/20 backdrop-blur-xl border border-white/30 rounded-2xl p-5 text-white shadow-2xl">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold uppercase tracking-wider text-white/80">Featured Specimen</span>
                        <span class="w-2.5 h-2.5 rounded-full bg-white animate-pulse"></span>
                    </div>
                    <h3 class="text-lg font-bold tracking-tight">Halfmoon &amp; Tetra Collection</h3>
                    <p class="text-xs text-white/85 mt-1 mb-4 leading-relaxed">
                        Spesimen hasil seleksi genetik dengan karantina parameter air terukur.
                    </p>
                    <a href="#katalog" class="inline-flex items-center justify-between w-full bg-white text-brand-ink px-4 py-2 rounded-full text-xs font-bold hover:bg-brand-orange hover:text-white transition">
                        <span>Explore catalog</span>
                        <span class="w-5 h-5 rounded-full bg-brand-ink text-white flex items-center justify-center">
                            <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
                        </span>
                    </a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="hero-slide absolute inset-0 transition-opacity duration-700 opacity-0 pointer-events-none">
                <img src="https://images.pexels.com/photos/325044/pexels-photo-325044.jpeg?auto=compress&cs=tinysrgb&w=1600"
                     alt="Ekosistem Tanaman Air & Aquascape" loading="lazy"
                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546026423-cc4642628d2b?auto=format&fit=crop&w=1600&q=85';"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>

                <div class="absolute bottom-8 left-8 sm:bottom-12 sm:left-12 max-w-xs bg-white/20 backdrop-blur-xl border border-white/30 rounded-2xl p-5 text-white shadow-2xl">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold uppercase tracking-wider text-white/80">Botanical Flora</span>
                        <span class="w-2.5 h-2.5 rounded-full bg-brand-orange"></span>
                    </div>
                    <h3 class="text-lg font-bold tracking-tight">Low-Tech Aquatic Plants</h3>
                    <p class="text-xs text-white/85 mt-1 mb-4 leading-relaxed">
                        Tanaman air adaptif untuk hardscape natural maupun minimalist tank.
                    </p>
                    <a href="#kalkulator" class="inline-flex items-center justify-between w-full bg-white text-brand-ink px-4 py-2 rounded-full text-xs font-bold hover:bg-brand-orange hover:text-white transition">
                        <span>Calculate tank setup</span>
                        <span class="w-5 h-5 rounded-full bg-brand-ink text-white flex items-center justify-center">
                            <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
                        </span>
                    </a>
                </div>
            </div>

            <!-- Slider Controls -->
            <div class="absolute bottom-8 right-8 flex items-center gap-2 z-10">
                <button onclick="setSlide(0)" aria-label="Slide 1" class="slider-dot w-9 h-2 rounded-full bg-white transition-all"></button>
                <button onclick="setSlide(1)" aria-label="Slide 2" class="slider-dot w-4 h-2 rounded-full bg-white/40 transition-all"></button>
            </div>
        </div>
    </section>

    <!-- Bento Grid Section: Reimagining Aquaculture with Purpose -->
    <section id="filosofi" class="max-w-7xl mx-auto px-6 py-20 border-t border-zinc-100">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Kolom Kiri: Editorial Heading + Abstract Bento Shapes -->
            <div class="lg:col-span-5 flex flex-col justify-between pr-0 lg:pr-6">
                <div id="filosofi-header">
                    <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-semibold tracking-[-0.03em] leading-[1.12] text-brand-ink">
                        Reimagining aquatic cultivation with purpose
                    </h2>
                    <p class="text-zinc-500 text-sm leading-relaxed mt-4">
                        Kami memadukan standar kualitas air terkontrol, pembiakan selektif, dan desain ekosistem alami untuk memberikan nilai estetika jangka panjang.
                    </p>
                </div>

                <!-- Decorative Geometric Bento Tiles -->
                <div id="filosofi-shapes" class="grid grid-cols-2 gap-3 mt-10">
                    <div class="h-28 rounded-3xl bg-brand-surface flex items-center justify-center text-zinc-400">
                        <i data-lucide="waves" class="w-7 h-7 stroke-[1.5]"></i>
                    </div>
                    <div class="h-28 rounded-3xl rounded-tr-[4rem] bg-brand-surface flex items-center justify-center text-zinc-400">
                        <i data-lucide="sprout" class="w-7 h-7 stroke-[1.5]"></i>
                    </div>
                    <div class="h-28 rounded-3xl bg-brand-surface flex items-center justify-center text-zinc-400">
                        <i data-lucide="shield-check" class="w-7 h-7 stroke-[1.5]"></i>
                    </div>
                    <div class="h-28 rounded-3xl bg-brand-surface flex items-center justify-center text-zinc-400">
                        <i data-lucide="sparkles" class="w-7 h-7 stroke-[1.5]"></i>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Pastel Bento Cards -->
            <div id="filosofi-cards" class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Card 1: Cream -->
                <div class="bg-brand-cream rounded-[2rem] p-8 flex flex-col justify-between min-h-[270px]">
                    <div class="w-10 h-10 rounded-xl bg-brand-ink text-white flex items-center justify-center">
                        <i data-lucide="droplets" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold tracking-tight text-brand-ink">Living smart</h3>
                        <p class="text-xs text-zinc-600 mt-2 leading-relaxed">
                            Sistem filtrasi biologis dan parameter pH terjaga untuk kesehatan ikan optimal.
                        </p>
                    </div>
                </div>

                <!-- Geometric Spacer Card -->
                <div class="hidden sm:flex bg-brand-surface rounded-[2rem] rounded-tl-[5rem] p-8 items-end justify-end min-h-[270px]">
                    <span class="text-xs font-mono uppercase tracking-widest text-zinc-400">Cirebon &bull; ID</span>
                </div>

                <!-- Card 2: Sky Blue -->
                <div class="bg-brand-sky rounded-[2rem] p-8 flex flex-col justify-between min-h-[270px]">
                    <div class="w-10 h-10 rounded-xl bg-brand-ink text-white flex items-center justify-center">
                        <i data-lucide="fish" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold tracking-tight text-brand-ink">Thriving together</h3>
                        <p class="text-xs text-zinc-600 mt-2 leading-relaxed">
                            Komunitas ikan hias ramah ekosistem yang harmonis dengan flora aquascape.
                        </p>
                    </div>
                </div>

                <!-- Card 3: Peach -->
                <div class="bg-brand-peach rounded-[2rem] p-8 flex flex-col justify-between min-h-[270px]">
                    <div class="w-10 h-10 rounded-xl bg-brand-ink text-white flex items-center justify-center">
                        <i data-lucide="layers" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold tracking-tight text-brand-ink">Iconic aquascapes</h3>
                        <p class="text-xs text-zinc-600 mt-2 leading-relaxed">
                            Material hardscape alami dan tanaman pilihan untuk tata ruang modern.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Signature Specimens Section -->
    <?php if (!empty($unggulan)): ?>
    <section id="signature" class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center max-w-xl mx-auto mb-14">
            <h2 class="text-3xl sm:text-5xl font-semibold tracking-[-0.03em] leading-[1.08] text-brand-ink">
                Our signature specimens
            </h2>
        </div>

        <div class="space-y-8">
            <?php
            $card_themes = [
                ['bg' => 'bg-brand-surface', 'pill' => 'bg-zinc-200/80 text-zinc-700'],
                ['bg' => 'bg-brand-sky',     'pill' => 'bg-blue-200/70 text-blue-900'],
                ['bg' => 'bg-brand-peach',   'pill' => 'bg-orange-200/70 text-orange-900'],
            ];
            foreach ($unggulan as $idx => $sig):
                $theme = $card_themes[$idx % count($card_themes)];
                $img_src = (!empty($sig['gambar']) && $sig['gambar'] !== 'default.jpg' && file_exists(__DIR__ . '/assets/img/' . $sig['gambar']))
                    ? 'assets/img/' . htmlspecialchars($sig['gambar'], ENT_QUOTES, 'UTF-8')
                    : ($sku_images[$sig['kode_produk']] ?? ($cdn_images[$sig['kategori']] ?? $fallback_img));
            ?>
            <div class="signature-card <?= $theme['bg'] ?> rounded-[2.5rem] p-8 sm:p-12 lg:p-14 transition-all shadow-xs">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
                    <!-- Kiri: Judul Display Besar + Visual Komoditas -->
                    <div class="lg:col-span-6">
                        <h3 class="text-4xl sm:text-5xl lg:text-6xl font-semibold tracking-[-0.035em] leading-[1.02] text-brand-ink uppercase">
                            <?= htmlspecialchars($sig['nama_produk'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>
                        <p class="text-xs font-medium text-zinc-500 mt-3 mb-8">
                            <?= htmlspecialchars($sig['kategori'], ENT_QUOTES, 'UTF-8') ?> &nbsp;/&nbsp; SKU <?= htmlspecialchars($sig['kode_produk'], ENT_QUOTES, 'UTF-8') ?> &nbsp;/&nbsp; Cirebon Farm
                        </p>
                        <div class="rounded-3xl overflow-hidden h-64 sm:h-72 bg-white shadow-sm">
                            <img src="<?= $img_src ?>" alt="<?= htmlspecialchars($sig['nama_produk'], ENT_QUOTES, 'UTF-8') ?>" 
                                 loading="lazy" onerror="this.onerror=null; this.src='<?= $fallback_img ?>';" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Kanan: Spec Card Putih dengan Harga Oranye Menyala -->
                    <div class="lg:col-span-6">
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            <span class="px-4 py-1.5 rounded-full bg-white text-brand-ink text-xs font-bold uppercase tracking-wider shadow-xs">
                                <?= htmlspecialchars($sig['kode_produk'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                            <span class="px-4 py-1.5 rounded-full <?= $theme['pill'] ?> text-xs font-semibold">
                                Quarantine Certified
                            </span>
                        </div>

                        <div class="bg-white rounded-[2rem] p-7 sm:p-8 shadow-xs">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h4 class="text-xl font-bold tracking-tight text-brand-ink uppercase">
                                        <?= htmlspecialchars($sig['nama_produk'], ENT_QUOTES, 'UTF-8') ?><sup class="text-xs font-normal">TM</sup>
                                    </h4>
                                    <p class="text-xs text-zinc-500 mt-1 line-clamp-2">
                                        <?= htmlspecialchars($sig['deskripsi'] ?: 'Komoditas budidaya unggul siap kirim.', ENT_QUOTES, 'UTF-8') ?>
                                    </p>
                                </div>
                                <a href="https://wa.me/6281234567890?text=Halo%20Mina%20Aquascape,%20saya%20ingin%20memesan%20<?= urlencode($sig['nama_produk']) ?>" target="_blank"
                                   class="w-10 h-10 rounded-full bg-brand-surface hover:bg-brand-ink hover:text-white flex items-center justify-center shrink-0 transition">
                                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                                </a>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 mt-6">
                                <!-- Highlight Harga Oranye -->
                                <div class="sm:col-span-7 bg-brand-orange text-white rounded-2xl p-4">
                                    <p class="text-[11px] font-medium text-white/85">Unit Price</p>
                                    <p class="text-lg sm:text-xl font-bold mt-0.5">
                                        Rp <?= number_format($sig['harga'], 0, ',', '.') ?> <span class="text-xs font-normal">/ <?= htmlspecialchars($sig['satuan'], ENT_QUOTES, 'UTF-8') ?></span>
                                    </p>
                                </div>
                                <!-- Info Stok -->
                                <div class="sm:col-span-5 bg-brand-surface rounded-2xl p-4">
                                    <p class="text-[11px] font-medium text-zinc-500">Available Stock</p>
                                    <p class="text-base font-bold text-brand-ink mt-0.5">
                                        <?= (int)$sig['stok'] ?> <?= htmlspecialchars($sig['satuan'], ENT_QUOTES, 'UTF-8') ?>
                                    </p>
                                </div>
                            </div>

                            <div class="mt-3 bg-brand-surface rounded-2xl p-4 flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-medium text-zinc-500">Status</p>
                                    <p class="text-sm font-semibold text-brand-ink mt-0.5">
                                        <?= $sig['stok'] > 0 ? 'Ready for Dispatch' : 'Restocking Batch' ?>
                                    </p>
                                </div>
                                <span class="w-2.5 h-2.5 rounded-full <?= $sig['stok'] > 0 ? 'bg-emerald-500' : 'bg-amber-500' ?>"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Full Interactive Catalog (DOM Category Filter) -->
    <section id="katalog" class="max-w-7xl mx-auto px-6 py-20 border-t border-zinc-100">
        <div id="katalog-header" class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-brand-orange mb-2">Live Inventory</p>
                <h2 class="text-3xl sm:text-4xl font-semibold tracking-[-0.03em] text-brand-ink">
                    Complete Cultivation Catalog
                </h2>
            </div>

            <!-- Filter Pills -->
            <div class="flex flex-wrap gap-2" id="gallery-filters">
                <button data-filter="ALL" class="filter-btn px-4 py-2 rounded-full text-xs font-semibold bg-brand-ink text-white transition">All Items</button>
                <button data-filter="Ikan Hias" class="filter-btn px-4 py-2 rounded-full text-xs font-semibold bg-brand-surface text-zinc-600 hover:bg-zinc-200 transition">Ikan Hias</button>
                <button data-filter="Tanaman Air" class="filter-btn px-4 py-2 rounded-full text-xs font-semibold bg-brand-surface text-zinc-600 hover:bg-zinc-200 transition">Tanaman Air</button>
                <button data-filter="Hardscape & Media" class="filter-btn px-4 py-2 rounded-full text-xs font-semibold bg-brand-surface text-zinc-600 hover:bg-zinc-200 transition">Hardscape &amp; Media</button>
                <button data-filter="Pakan & Obat" class="filter-btn px-4 py-2 rounded-full text-xs font-semibold bg-brand-surface text-zinc-600 hover:bg-zinc-200 transition">Pakan &amp; Obat</button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="gallery-grid">
            <?php foreach ($katalog as $item):
                $thumb = (!empty($item['gambar']) && $item['gambar'] !== 'default.jpg' && file_exists(__DIR__ . '/assets/img/' . $item['gambar']))
                    ? 'assets/img/' . htmlspecialchars($item['gambar'], ENT_QUOTES, 'UTF-8')
                    : ($sku_images[$item['kode_produk']] ?? ($cdn_images[$item['kategori']] ?? $fallback_img));
            ?>
            <div class="gallery-card group bg-brand-surface rounded-[2rem] p-4 flex flex-col justify-between transition hover:bg-zinc-100"
                 data-kategori="<?= htmlspecialchars($item['kategori'], ENT_QUOTES, 'UTF-8') ?>">
                <div>
                    <div class="relative h-48 rounded-2xl overflow-hidden bg-white mb-4">
                        <img src="<?= $thumb ?>" alt="<?= htmlspecialchars($item['nama_produk'], ENT_QUOTES, 'UTF-8') ?>" 
                             loading="lazy" onerror="this.onerror=null; this.src='<?= $fallback_img ?>';"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/90 backdrop-blur text-brand-ink text-[11px] font-semibold shadow-xs">
                            <?= htmlspecialchars($item['kategori'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </div>
                    <div class="px-2">
                        <p class="text-[11px] font-mono text-zinc-400"><?= htmlspecialchars($item['kode_produk'], ENT_QUOTES, 'UTF-8') ?></p>
                        <h3 class="font-bold text-brand-ink text-base mt-0.5"><?= htmlspecialchars($item['nama_produk'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p class="text-xs text-zinc-500 line-clamp-2 mt-1.5 leading-relaxed"><?= htmlspecialchars($item['deskripsi'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>

                <div class="mt-5 pt-4 px-2 border-t border-zinc-200/70 flex items-center justify-between">
                    <div>
                        <p class="text-base font-extrabold text-brand-ink">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                        <p class="text-[11px] text-zinc-500">Stock: <?= (int)$item['stok'] ?> <?= htmlspecialchars($item['satuan'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                    <a href="https://wa.me/6281234567890?text=Halo%20Mina%20Aquascape,%20saya%20tertarik%20pesan%20<?= urlencode($item['nama_produk']) ?>" target="_blank"
                       aria-label="Order <?= htmlspecialchars($item['nama_produk'], ENT_QUOTES, 'UTF-8') ?>"
                       class="w-10 h-10 rounded-full bg-brand-ink text-white group-hover:bg-brand-orange flex items-center justify-center transition">
                        <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Tank Setup Calculator Section (Neo-Editorial Bento) -->
    <section id="kalkulator" class="max-w-7xl mx-auto px-6 py-20">
        <div id="calculator-card" class="bg-brand-ink text-white rounded-[2.5rem] p-8 sm:p-12 lg:p-16 shadow-lg">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-5">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 text-brand-orange text-xs font-semibold mb-4">
                        <i data-lucide="calculator" class="w-3.5 h-3.5"></i>
                        <span>Aquascape Estimator</span>
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-semibold tracking-[-0.03em] leading-tight">
                        Calculate your aquarium substrate &amp; capacity
                    </h2>
                    <p class="text-zinc-400 text-sm mt-4 leading-relaxed">
                        Masukkan dimensi panjang, lebar, dan tinggi akuarium dalam sentimeter untuk menghitung volume air, kebutuhan pasir silika, serta kapasitas populasi ideal.
                    </p>
                </div>

                <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Form Input -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-zinc-400 mb-1.5">Length / Panjang (cm)</label>
                            <input type="number" id="calc-p" value="60" min="10" class="w-full px-4 py-2.5 rounded-xl bg-zinc-950 border border-zinc-800 text-white text-sm focus:border-brand-orange outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-400 mb-1.5">Width / Lebar (cm)</label>
                            <input type="number" id="calc-l" value="30" min="10" class="w-full px-4 py-2.5 rounded-xl bg-zinc-950 border border-zinc-800 text-white text-sm focus:border-brand-orange outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-400 mb-1.5">Height / Tinggi (cm)</label>
                            <input type="number" id="calc-t" value="35" min="10" class="w-full px-4 py-2.5 rounded-xl bg-zinc-950 border border-zinc-800 text-white text-sm focus:border-brand-orange outline-none">
                        </div>
                        <button onclick="hitungAquascape()" class="w-full py-3 rounded-xl bg-brand-orange hover:bg-orange-600 text-white font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2">
                            <span>Run Calculation</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <!-- Output Result -->
                    <div class="flex flex-col justify-between gap-4">
                        <div class="bg-brand-orange rounded-3xl p-6 text-white shadow-sm">
                            <p class="text-xs font-medium text-white/80">Total Water Volume</p>
                            <p id="res-liter" class="text-3xl font-extrabold mt-1">63 Liters</p>
                        </div>

                        <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6">
                            <p class="text-xs font-medium text-zinc-400">Silica Sand Required (5cm layer)</p>
                            <p id="res-pasir" class="text-xl font-bold text-white mt-1">13.5 Kg <span class="text-xs font-normal text-zinc-400">(~Rp 162.000)</span></p>
                        </div>

                        <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6">
                            <p class="text-xs font-medium text-zinc-400">Population &amp; Lighting Spec</p>
                            <p id="res-ikan" class="text-sm font-semibold text-zinc-200 mt-1">Max 31 small fish &bull; LED 25–32 Watt</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Minimal Footer -->
    <footer class="max-w-7xl mx-auto px-6 py-10 border-t border-zinc-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-zinc-500">
        <div class="flex items-center gap-2 text-brand-ink font-bold">
            <span>MINA AQUASCAPE</span>
            <span class="text-zinc-300">/</span>
            <span class="font-normal text-zinc-500">Cirebon, West Java</span>
        </div>
        <p>&copy; <?= date('Y') ?> Capstone Project Pemrograman Web Dasar &bull; STMIK IKMI Cirebon</p>
    </footer>

    <!-- Initialize Lucide Icons, GSAP ScrollTrigger & Interactive Scripts -->
    <script>
        // Inisialisasi Ikon Lucide
        lucide.createIcons();

        // 1. Inisialisasi Animasi GSAP & ScrollTrigger (Neo-Editorial Reveal)
        gsap.registerPlugin(ScrollTrigger);

        // Hero Entrance Animation (Stagger Title, Subtitle & Showcase Frame saat awal muat)
        gsap.timeline({ defaults: { ease: "power3.out" } })
            .from("#hero-title", { opacity: 0, y: 40, duration: 0.9 })
            .from("#hero-desc", { opacity: 0, y: 25, duration: 0.8 }, "-=0.6")
            .from("#hero-frame", { opacity: 0, y: 30, scale: 0.98, duration: 0.9 }, "-=0.6");

        // Bento Philosophy Section Animations
        gsap.from("#filosofi-header > *", {
            scrollTrigger: {
                trigger: "#filosofi",
                start: "top 80%",
                once: true
            },
            opacity: 0,
            y: 30,
            stagger: 0.12,
            duration: 0.8,
            ease: "power2.out",
            clearProps: "all"
        });

        gsap.from("#filosofi-shapes > div", {
            scrollTrigger: {
                trigger: "#filosofi-shapes",
                start: "top 85%",
                once: true
            },
            opacity: 0,
            scale: 0.9,
            stagger: 0.08,
            duration: 0.7,
            ease: "power2.out",
            clearProps: "all"
        });

        gsap.from("#filosofi-cards > div", {
            scrollTrigger: {
                trigger: "#filosofi-cards",
                start: "top 80%",
                once: true
            },
            opacity: 0,
            y: 40,
            stagger: 0.12,
            duration: 0.8,
            ease: "power2.out",
            clearProps: "all"
        });

        // Signature Specimens Entrance Animation (Stagger Reveal per Card)
        gsap.utils.toArray('.signature-card').forEach((card) => {
            gsap.from(card, {
                scrollTrigger: {
                    trigger: card,
                    start: "top 85%",
                    once: true
                },
                opacity: 0,
                y: 45,
                duration: 0.9,
                ease: "power2.out",
                clearProps: "all"
            });
        });

        // Catalog Grid Stagger Animation (Aman dengan Filter DOM, clearProps membersihkan inline style)
        gsap.from("#katalog-header > *", {
            scrollTrigger: {
                trigger: "#katalog",
                start: "top 80%",
                once: true
            },
            opacity: 0,
            y: 30,
            stagger: 0.1,
            duration: 0.8,
            ease: "power2.out",
            clearProps: "all"
        });

        gsap.from("#gallery-grid .gallery-card", {
            scrollTrigger: {
                trigger: "#gallery-grid",
                start: "top 85%",
                once: true
            },
            opacity: 0,
            y: 35,
            stagger: 0.06,
            duration: 0.7,
            ease: "power2.out",
            clearProps: "all"
        });

        // Tank Setup Calculator Entrance Animation
        gsap.from("#calculator-card", {
            scrollTrigger: {
                trigger: "#kalkulator",
                start: "top 80%",
                once: true
            },
            opacity: 0,
            y: 45,
            duration: 0.9,
            ease: "power2.out",
            clearProps: "all"
        });

        // 2. Hero Showcase Slider
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slider-dot');

        function setSlide(index) {
            currentSlide = index;
            slides.forEach((s, i) => {
                s.classList.toggle('opacity-100', i === index);
                s.classList.toggle('opacity-0', i !== index);
                s.classList.toggle('pointer-events-none', i !== index);
            });
            dots.forEach((d, i) => {
                d.classList.toggle('w-9', i === index);
                d.classList.toggle('bg-white', i === index);
                d.classList.toggle('w-4', i !== index);
                d.classList.toggle('bg-white/40', i !== index);
            });
        }
        setInterval(() => setSlide((currentSlide + 1) % slides.length), 6000);

        // 3. DOM Gallery Category Filter
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.getAttribute('data-filter');
                document.querySelectorAll('.filter-btn').forEach(b => {
                    b.classList.remove('bg-brand-ink', 'text-white');
                    b.classList.add('bg-brand-surface', 'text-zinc-600');
                });
                btn.classList.add('bg-brand-ink', 'text-white');
                btn.classList.remove('bg-brand-surface', 'text-zinc-600');

                document.querySelectorAll('.gallery-card').forEach(card => {
                    const kat = card.getAttribute('data-kategori');
                    card.classList.toggle('hidden', filter !== 'ALL' && kat !== filter);
                });
            });
        });

        // 4. Tank Setup Calculator
        function hitungAquascape() {
            const p = parseFloat(document.getElementById('calc-p').value) || 0;
            const l = parseFloat(document.getElementById('calc-l').value) || 0;
            const t = parseFloat(document.getElementById('calc-t').value) || 0;

            const liter = Math.round((p * l * t) / 1000);
            const pasirKg = ((p * l * 5) / 1000 * 1.5).toFixed(1);
            const estimasiBiaya = Math.ceil(pasirKg) * 12000;
            const maksIkan = Math.max(1, Math.floor(liter / 2));
            const wattMin = Math.round(liter * 0.4);
            const wattMax = Math.round(liter * 0.5);

            document.getElementById('res-liter').textContent = `${liter} Liters`;
            document.getElementById('res-pasir').innerHTML = `${pasirKg} Kg <span class="text-xs font-normal text-zinc-400">(~Rp ${estimasiBiaya.toLocaleString('id-ID')})</span>`;
            document.getElementById('res-ikan').textContent = `Max ${maksIkan} small fish • LED ${wattMin}–${wattMax} Watt`;
        }
    </script>
</body>
</html>
