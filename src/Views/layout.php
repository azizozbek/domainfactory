<!doctype html>
<html lang="en" class="h-full bg-white-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    <title><?php echo htmlspecialchars($title ?? 'Domain Manager'); ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" nonce="<?php $nonce = htmlspecialchars($_SESSION['nonce'] ?? ''); echo $nonce; ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module" nonce="<?php echo $nonce;  ?>"></script>
</head>
<body class="h-full">
    <div class="min-h-full">
        <header class="relative bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between">
                <a href="/"><h1 class="text-3xl font-bold tracking-tight text-gray-900">Domain Management</h1></a>
                <button id="refreshDomainList" data-url="<?php echo "https://" . $_SERVER['HTTP_HOST'] . '/refresh?nonce='. htmlspecialchars($_SESSION['nonce'] ?? ''); ?>" class="flex gap-4 items-center hover:text-red-500 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5" id="rotator">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Refresh Domain List
                </button>
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
<script src="/assets/scripts.js" nonce="<?php echo $nonce;  ?>"></script>
</html>