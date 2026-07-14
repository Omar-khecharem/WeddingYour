<?php
$products = $products ?? [];
$pagination = $pagination ?? ['currentPage' => 1, 'totalPages' => 1, 'hasPrev' => false, 'hasNext' => false, 'prevPage' => 1, 'nextPage' => 1];
$search = $_GET['search'] ?? '';
$categoryFilter = $_GET['category'] ?? '';
$statusFilter = $_GET['status'] ?? '';
?>
<div class="flex h-screen overflow-hidden bg-gray-50">
    <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 overflow-y-auto hidden lg:block">
        <div class="p-5 border-b border-gray-200">
            <a href="<?= url('admin') ?>" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-primary-red flex items-center justify-center text-white font-bold text-sm">A</div>
                <div><span class="font-bold text-gray-800 text-sm">Administration</span><p class="text-xs text-gray-400">Panneau de contrôle</p></div>
            </a>
        </div>
        <nav class="p-4 space-y-1">
            <a href="<?= url('admin') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-chart-pie w-5 text-center"></i> Tableau de bord</a>
            <a href="<?= url('admin/products') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium bg-primary-red/10 text-primary-red transition-colors"><i class="fa-solid fa-box w-5 text-center"></i> Produits</a>
            <a href="<?= url('admin/orders') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-truck w-5 text-center"></i> Commandes</a>
            <a href="<?= url('admin/users') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-users w-5 text-center"></i> Clients</a>
            <a href="<?= url('admin/reviews') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-star w-5 text-center"></i> Avis</a>
            <a href="<?= url('admin/coupons') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-tag w-5 text-center"></i> Coupons</a>
            <a href="<?= url('admin/pages') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-file w-5 text-center"></i> Pages</a>
            <hr class="my-3 border-gray-200">
            <a href="<?= url('admin/settings') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-gear w-5 text-center"></i> Paramètres</a>
            <a href="<?= url('admin/logs') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-list w-5 text-center"></i> Logs</a>
        </nav>
    </aside>
    <main class="flex-1 overflow-y-auto">
        <div class="max-w-[1400px] mx-auto py-6 px-4 lg:px-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Produits</h1>
                    <p class="text-sm text-gray-500">Gérez votre catalogue de produits</p>
                </div>
                <a href="<?= url('admin/products/create') ?>" class="bg-primary-red text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:opacity-90 transition-all inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Ajouter un produit
                </a>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
                <form method="GET" action="<?= url('admin/products') ?>" class="flex flex-wrap items-end gap-3">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Recherche</label>
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="search" value="<?= e($search) ?>" placeholder="Nom du produit, SKU..." class="w-full border border-gray-300 rounded-lg pl-9 pr-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Catégorie</label>
                        <select name="category" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                            <option value="">Toutes les catégories</option>
                            <?php foreach ($categories ?? [] as $cat): ?>
                            <option value="<?= e($cat['id'] ?? $cat) ?>" <?= $categoryFilter === ($cat['id'] ?? $cat) ? 'selected' : '' ?>><?= e($cat['name'] ?? $cat) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Statut</label>
                        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                            <option value="">Tous</option>
                            <option value="active" <?= $statusFilter === 'active' ? 'selected' : '' ?>>Actif</option>
                            <option value="draft" <?= $statusFilter === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                            <option value="inactive" <?= $statusFilter === 'inactive' ? 'selected' : '' ?>>Inactif</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-primary-red text-white px-5 py-2 rounded-lg text-sm font-medium hover:opacity-90 transition-all">Filtrer</button>
                    <a href="<?= url('admin/products') ?>" class="border border-gray-300 text-gray-600 px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-all">Réinitialiser</a>
                </form>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Produit</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">SKU</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Catégorie</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Prix</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Stock</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Statut</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                                    <i class="fa-solid fa-box-open text-3xl mb-2 block text-gray-300"></i>
                                    Aucun produit trouvé
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($products as $product): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <?php if (!empty($product['image'])): ?>
                                        <img src="<?= asset('images/' . e($product['image'])) ?>" alt="<?= e($product['name']) ?>" class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                                        <?php else: ?>
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400"><i class="fa-solid fa-image"></i></div>
                                        <?php endif; ?>
                                        <div>
                                            <a href="<?= url('admin/products/' . e($product['id']) . '/edit') ?>" class="font-medium text-gray-800 hover:text-primary-red transition-colors"><?= e($product['name']) ?></a>
                                            <?php if (!empty($product['brand'])): ?>
                                            <p class="text-xs text-gray-400"><?= e($product['brand']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-gray-500 font-mono text-xs"><?= e($product['sku'] ?? 'N/A') ?></td>
                                <td class="px-5 py-3 text-gray-500"><?= e($product['category_name'] ?? $product['category'] ?? 'N/A') ?></td>
                                <td class="px-5 py-3">
                                    <div class="font-medium text-gray-800"><?= formatPrice($product['regular_price'] ?? 0) ?></div>
                                    <?php if (!empty($product['sale_price'])): ?>
                                    <div class="text-xs text-red-500 line-through"><?= formatPrice($product['sale_price']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3">
                                    <?php $qty = $product['stock_quantity'] ?? 0; ?>
                                    <?php if ($qty > 10): ?>
                                    <span class="text-green-600 font-medium"><?= $qty ?></span>
                                    <?php elseif ($qty > 0): ?>
                                    <span class="text-yellow-600 font-medium"><?= $qty ?></span>
                                    <?php else: ?>
                                    <span class="text-red-600 font-medium">Épuisé</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3">
                                    <?php $ps = $product['status'] ?? ''; ?>
                                    <?php if ($ps === 'active'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Actif</span>
                                    <?php elseif ($ps === 'draft'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Brouillon</span>
                                    <?php elseif ($ps === 'inactive'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Inactif</span>
                                    <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600"><?= e($ps ?: 'N/A') ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-1">
                                        <a href="<?= url('admin/products/' . e($product['id']) . '/edit') ?>" class="p-1.5 text-gray-400 hover:text-primary-red transition-colors" title="Modifier"><i class="fa-solid fa-pen"></i></a>
                                        <a href="<?= url('products/' . e($product['slug'] ?? $product['id'])) ?>" target="_blank" class="p-1.5 text-gray-400 hover:text-blue-600 transition-colors" title="Voir sur le site"><i class="fa-solid fa-external-link"></i></a>
                                        <button onclick="confirmDelete(<?= e($product['id']) ?>)" class="p-1.5 text-gray-400 hover:text-red-600 transition-colors" title="Supprimer"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?= \App\Core\View::component('Pagination', [
                'currentPage' => $pagination['currentPage'],
                'totalPages' => $pagination['totalPages'],
                'baseUrl' => url('admin/products?') . ($search ? 'search=' . e($search) . '&' : '') . ($categoryFilter ? 'category=' . e($categoryFilter) . '&' : '') . ($statusFilter ? 'status=' . e($statusFilter) . '&' : ''),
            ]) ?>
        </div>
    </main>
</div>
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
        window.location.href = '<?= url('admin/products') ?>/' + id + '/delete';
    }
}
</script>
