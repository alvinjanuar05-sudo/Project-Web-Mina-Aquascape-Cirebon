<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <title>Admin Workspace — Mina Aquascape</title>
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
<body class="bg-brand-surface text-brand-ink font-sans antialiased selection:bg-brand-orange selection:text-white">
    <div class="min-h-screen flex">