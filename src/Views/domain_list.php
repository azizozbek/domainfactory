<div>
    <h2 class="text-xl mt-10 mb-2">Current Domain List</h2>
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
