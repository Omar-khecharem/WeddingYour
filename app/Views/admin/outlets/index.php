<?php $outlets = $outlets ?? []; ?>
<div class="flex items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Outlets</h1>
        <p class="text-sm text-gray-500">Manage <?= e(\App\Models\Setting::get('site_name', 'Shola Ghar')) ?>'s store locations</p>
    </div>
    <a href="<?= url('admin/outlets/create') ?>" class="bg-primary-red text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:opacity-90 transition-all inline-flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Add Outlet
    </a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (empty($outlets)): ?>
    <div class="col-span-full text-center py-12 text-gray-400">No outlets found</div>
    <?php else: ?>
    <?php foreach ($outlets as $o): ?>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <?php if (!empty($o['image'])): ?>
        <img src="<?= uploadUrl($o['image']) ?>" alt="<?= e($o['name']) ?>" class="w-full h-48 object-cover">
        <?php else: ?>
        <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400"><i class="fa-solid fa-store fa-3x"></i></div>
        <?php endif; ?>
        <div class="p-5">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-bold text-gray-800"><?= e($o['name']) ?></h3>
                <?php if ($o['is_active']): ?>
                <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Active</span>
                <?php else: ?>
                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">Inactive</span>
                <?php endif; ?>
            </div>
            <p class="text-sm text-gray-500 mb-3"><?= e($o['address'] ?? '') ?>, <?= e($o['city'] ?? '') ?></p>
            <p class="text-sm text-gray-500"><i class="fa-solid fa-phone mr-1"></i> <?= e($o['phone'] ?? 'N/A') ?></p>
            <div class="flex gap-2 mt-4">
                <a href="<?= url('admin/outlets/edit/' . $o['id']) ?>" class="flex-1 text-center border border-gray-300 text-gray-600 px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors"><i class="fa-solid fa-pen mr-1"></i> Edit</a>
                <button onclick="confirmDelete(<?= $o['id'] ?>)" class="border border-red-300 text-red-600 px-3 py-2 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors"><i class="fa-solid fa-trash"></i></button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php startSection('scripts') ?>
<script>function confirmDelete(id){if(confirm('Delete this outlet?')){var f=document.createElement('form');f.method='POST';f.action='<?= url('admin/outlets/delete') ?>';f.innerHTML='<?= \App\Helpers\Security::csrfField() ?>';var i=document.createElement('input');i.type='hidden';i.name='id';i.value=id;f.appendChild(i);document.body.appendChild(f);f.submit();}}</script>
<?php endSection() ?>
