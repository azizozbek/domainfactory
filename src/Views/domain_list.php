<div class="mt-10 mb-2">
    <div class="flex justify-between items-center py-2">
        <h2 class="text-xl">Current Domain List</h2>
        <a href="/refresh" class="flex gap-4 items-center hover:text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
            Refresh List
        </a>
    </div>
    <?php foreach ($list as $domain): $status = \App\Services\PleskWebspaceStatusEnum::tryFrom($domain['status']); ?>
        <div class="flex justify-between bg-gray-100 border-l-4 border-<?php echo $status->color() ?>-500 p-5 rounded-md mb-2 items-center hover:bg-<?php echo $status->color() ?>-100" open>
            <h3 class="text-xl font-semibold text-gray-900"><?php echo $domain['name']; ?></h3>
            <div class="flex gap-5">
                <span>Status: <?php echo $status->label(); ?></span>
                <span>Created: <?php echo (new DateTime($domain['created']))->format("d.m.Y"); ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>
