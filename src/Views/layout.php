<!doctype html>
<html lang="en" class="h-full bg-white-900">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title ?? 'Domain Manager'); ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" nonce="<?php $nonce = htmlspecialchars($_SESSION['nonce'] ?? ''); echo $nonce; ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module" nonce="<?php echo $nonce;  ?>"></script>
    <script src="/assets/scripts.js" nonce="<?php echo $nonce;  ?>"></script>
</head>
<body class="h-full">
    <div class="min-h-full">
        <header class="relative bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <a href="/"><h1 class="text-3xl font-bold tracking-tight text-gray-900">Domain Management</h1></a>
                <a href=""></a>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <?php echo $domainForm; ?>
                <?php echo $domainList; ?>
            </div>
        </main>
    </div>
</body>
</html>