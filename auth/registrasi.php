<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $token)) {
        $error = "Token keamanan tidak valid.";
    } else {
        $nama = trim($_POST['nama_lengkap'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (strlen($username) < 4 || strlen($password) < 6) {
            $error = "Username minimal 4 karakter dan password minimal 6 karakter.";
        } else {
            $cek = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $cek->execute([$username]);

            if ($cek->fetch()) {
                $error = "Username sudah terdaftar, silakan pilih username lain.";
            } else {
                $hashed = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("INSERT INTO users (nama_lengkap, username, password) VALUES (?, ?, ?)");
                $stmt->execute([$nama, $username, $hashed]);

                header("Location: login.php?registered=1");
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Registration — Mina Aquascape</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: {
                        brand: {
                            orange: '#FF5500',
                            surface: '#F6F6F5',
                            ink: '#18181B'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-surface text-brand-ink font-sans antialiased min-h-screen flex flex-col justify-between p-6">

    <!-- Top Navigation Bar -->
    <div class="max-w-6xl w-full mx-auto flex items-center justify-between">
        <a href="login.php" class="inline-flex items-center gap-2 text-xs font-semibold text-zinc-500 hover:text-brand-ink transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Back to Login</span>
        </a>
        <a href="../index.php" aria-label="Mina Aquascape Home">
            <svg class="w-7 h-7 text-brand-ink" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 8L13 28H17L11 14L18 28L25 14L19 28H23L32 8H26.5L18 24L9.5 8H4Z" fill="currentColor"/>
            </svg>
        </a>
        <span class="text-xs font-mono text-zinc-400">CIREBON &bull; ID</span>
    </div>

    <!-- Center Registration Card -->
    <div class="w-full max-w-md mx-auto my-8">
        <div class="bg-white rounded-[2.25rem] p-8 sm:p-10 shadow-xs border border-zinc-100">
            <div class="mb-8">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-surface text-zinc-600 text-[11px] font-semibold uppercase tracking-wider mb-3">
                    <i data-lucide="user-plus" class="w-3 h-3 text-brand-orange"></i>
                    <span>New Operator</span>
                </span>
                <h1 class="text-3xl font-semibold tracking-[-0.03em] text-brand-ink">
                    Register Account
                </h1>
                <p class="text-xs text-zinc-500 mt-1.5">
                    Buat kredensial pengelola baru dengan enkripsi Bcrypt.
                </p>
            </div>

            <?php if ($error): ?>
                <div class="flex items-center gap-2.5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-5 text-xs font-medium">
                    <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                    <span><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                <div>
                    <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3.5 flex items-center text-zinc-400">
                            <i data-lucide="badge-check" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="nama_lengkap" required placeholder="Contoh: Muhammad Alvin Januar"
                               class="w-full pl-10 pr-4 py-3 rounded-2xl bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink text-sm outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3.5 flex items-center text-zinc-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="username" required placeholder="Minimal 4 karakter"
                               class="w-full pl-10 pr-4 py-3 rounded-2xl bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink text-sm outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3.5 flex items-center text-zinc-400">
                            <i data-lucide="key-round" class="w-4 h-4"></i>
                        </span>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter"
                               class="w-full pl-10 pr-4 py-3 rounded-2xl bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink text-sm outline-none transition">
                    </div>
                </div>

                <button type="submit" class="w-full mt-2 py-3.5 rounded-full bg-brand-ink hover:bg-brand-orange text-white font-semibold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2">
                    <span>Create Operator Account</span>
                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-zinc-100 text-center">
                <p class="text-xs text-zinc-500">
                    Sudah memiliki akun?
                    <a href="login.php" class="text-brand-ink font-bold hover:text-brand-orange transition underline underline-offset-4">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

    <div class="text-center text-[11px] text-zinc-400">
        &copy; <?= date('Y') ?> Mina Aquascape &bull; Protected Session Environment
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>