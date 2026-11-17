<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../admin.php");
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $token)) {
        $error = "Token keamanan tidak valid.";
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare("SELECT id, nama_lengkap, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            header("Location: ../admin.php");
            exit;
        } else {
            $error = "Username atau password tidak sesuai.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal — Mina Aquascape</title>
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
        <a href="../index.php" class="inline-flex items-center gap-2 text-xs font-semibold text-zinc-500 hover:text-brand-ink transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Back to Public Site</span>
        </a>
        <a href="../index.php" aria-label="Mina Aquascape Home">
            <svg class="w-7 h-7 text-brand-ink" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 8L13 28H17L11 14L18 28L25 14L19 28H23L32 8H26.5L18 24L9.5 8H4Z" fill="currentColor"/>
            </svg>
        </a>
        <span class="text-xs font-mono text-zinc-400">CIREBON &bull; ID</span>
    </div>

    <!-- Center Login Card -->
    <div class="w-full max-w-md mx-auto my-8">
        <div class="bg-white rounded-[2.25rem] p-8 sm:p-10 shadow-xs border border-zinc-100">
            <div class="mb-8">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-surface text-zinc-600 text-[11px] font-semibold uppercase tracking-wider mb-3">
                    <i data-lucide="lock" class="w-3 h-3 text-brand-orange"></i>
                    <span>Secure Access</span>
                </span>
                <h1 class="text-3xl font-semibold tracking-[-0.03em] text-brand-ink">
                    Admin Portal
                </h1>
                <p class="text-xs text-zinc-500 mt-1.5">
                    Masuk ke panel operasional budidaya &amp; inventaris Mina Aquascape.
                </p>
            </div>

            <?php if ($error): ?>
                <div class="flex items-center gap-2.5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-5 text-xs font-medium">
                    <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                    <span><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['registered'])): ?>
                <div class="flex items-center gap-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-5 text-xs font-medium">
                    <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
                    <span>Registrasi berhasil. Silakan masuk menggunakan akun baru Anda.</span>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                <div>
                    <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3.5 flex items-center text-zinc-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="username" required placeholder="admin"
                               class="w-full pl-10 pr-4 py-3 rounded-2xl bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink text-sm outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3.5 flex items-center text-zinc-400">
                            <i data-lucide="key-round" class="w-4 h-4"></i>
                        </span>
                        <input type="password" name="password" required placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-3 rounded-2xl bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink text-sm outline-none transition">
                    </div>
                </div>

                <button type="submit" class="w-full mt-2 py-3.5 rounded-full bg-brand-ink hover:bg-brand-orange text-white font-semibold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2">
                    <span>Sign In to Dashboard</span>
                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-zinc-100 text-center">
                <p class="text-xs text-zinc-500">
                    Belum memiliki akun pengelola?
                    <a href="registrasi.php" class="text-brand-ink font-bold hover:text-brand-orange transition underline underline-offset-4">
                        Daftar Pengelola
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