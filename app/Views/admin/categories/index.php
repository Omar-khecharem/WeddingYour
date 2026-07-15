<?php $categories = $categories ?? []; ?>
<div class="flex items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
        <p class="text-sm text-gray-500">Manage product categories</p>
    </div>
    <a href="<?= url('admin/categories/create') ?>" class="bg-primary-red text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:opacity-90 transition-all inline-flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Add Category
    </a>
</div>
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Image</th>
                    <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Name</th>
                    <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Slug</th>
                    <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Products</th>
                    <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Featured</th>
                    <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if (empty($categories)): ?>
                <tr><td colspan="7" class="px-5 py-12 text-center text-gray-400">No categories found</td></tr>
                <?php else: ?>
                <?php foreach ($categories as $cat): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3">
                        <?php if (!empty($cat['image'])): ?>
                        <img src="<?= uploadUrl($cat['image']) ?>" class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                        <?php else: ?>
                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400"><i class="fa-solid fa-folder"></i></div>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 font-medium text-gray-800"><?= e($cat['name']) ?></td>
                    <td class="px-5 py-3 text-gray-500 text-xs font-mono"><?= e($cat['slug']) ?></td>
                    <td class="px-5 py-3 text-gray-500"><?= $cat['product_count'] ?? 0 ?></td>
                    <td class="px-5 py-3"><?= $cat['featured'] ? '<span class="text-green-600"><i class="fa-solid fa-check"></i></span>' : '<span class="text-gray-300"><i class="fa-solid fa-xmark"></i></span>' ?></td>
                    <td class="px-5 py-3">
                        <?php if ($cat['status']): ?>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                        <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-1">
                            <a href="<?= url('admin/categories/edit/' . $cat['id']) ?>" class="p-1.5 text-gray-400 hover:text-primary-red transition-colors" title="Edit"><i class="fa-solid fa-pen"></i></a>
                            <button onclick="confirmDelete(<?= $cat['id'] ?>)" class="p-1.5 text-gray-400 hover:text-red-600 transition-colors" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php startSection('scripts') ?>
<script>function confirmDelete(id){if(confirm('Delete this category?')){var f=document.createElement('form');f.method='POST';f.action='<?= url('admin/categories/delete') ?>';f.innerHTML='<?= \App\Helpers\Security::csrfField() ?>';var i=document.createElement('input');i.type='hidden';i.name='id';i.value=id;f.appendChild(i);document.body.appendChild(f);f.submit();}}</script>
<?php endSection() ?>
