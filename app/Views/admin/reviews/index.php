<?php
$reviews = $reviews ?? [];
$pagination = $pagination ?? ['currentPage' => 1, 'totalPages' => 1, 'hasPrev' => false, 'hasNext' => false, 'prevPage' => 1, 'nextPage' => 1];
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
            <a href="<?= url('admin/products') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-box w-5 text-center"></i> Produits</a>
            <a href="<?= url('admin/orders') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-truck w-5 text-center"></i> Commandes</a>
            <a href="<?= url('admin/users') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-users w-5 text-center"></i> Clients</a>
            <a href="<?= url('admin/reviews') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium bg-primary-red/10 text-primary-red transition-colors"><i class="fa-solid fa-star w-5 text-center"></i> Avis</a>
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
                    <h1 class="text-2xl font-bold text-gray-800">Avis clients</h1>
                    <p class="text-sm text-gray-500">Modérez les avis laissés par vos clients</p>
                </div>
                <span class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-200"><?= $pagination['totalItems'] ?? count($reviews) ?> avis</span>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Produit</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Client</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Note</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Avis</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Statut</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Date</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if (empty($reviews)): ?>
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                                    <i class="fa-solid fa-star text-3xl mb-2 block text-gray-300"></i>
                                    Aucun avis trouvé
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($reviews as $review): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <?php if (!empty($review['product_image'])): ?>
                                        <img src="<?= asset('images/' . e($review['product_image'])) ?>" alt="<?= e($review['product_name']) ?>" class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                                        <?php else: ?>
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400"><i class="fa-solid fa-image"></i></div>
                                        <?php endif; ?>
                                        <a href="<?= url('admin/products/' . e($review['product_id']) . '/edit') ?>" class="font-medium text-gray-800 hover:text-primary-red transition-colors"><?= e($review['product_name'] ?? 'N/A') ?></a>
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="text-gray-800 font-medium"><?= e($review['customer_name'] ?? 'N/A') ?></div>
                                    <div class="text-xs text-gray-400"><?= e($review['customer_email'] ?? '') ?></div>
                                </td>
                                <td class="px-5 py-3"><?= starRating((int)($review['rating'] ?? 0)) ?></td>
                                <td class="px-5 py-3 max-w-xs">
                                    <p class="text-gray-600 truncate"><?= e(truncate($review['comment'] ?? '', 80)) ?></p>
                                </td>
                                <td class="px-5 py-3">
                                    <?php if (($review['status'] ?? '') === 'approved'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Approuvé</span>
                                    <?php elseif (($review['status'] ?? '') === 'pending'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">En attente</span>
                                    <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Rejeté</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3 text-gray-500 whitespace-nowrap"><?= formatDate($review['created_at'] ?? '') ?></td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-1">
                                        <?php if (($review['status'] ?? '') !== 'approved'): ?>
                                        <a href="<?= url('admin/reviews/' . e($review['id']) . '/approve') ?>" class="p-1.5 text-gray-400 hover:text-green-600 transition-colors" title="Approuver"><i class="fa-solid fa-check"></i></a>
                                        <?php endif; ?>
                                        <?php if (($review['status'] ?? '') !== 'rejected'): ?>
                                        <a href="<?= url('admin/reviews/' . e($review['id']) . '/reject') ?>" class="p-1.5 text-gray-400 hover:text-yellow-600 transition-colors" title="Rejeter"><i class="fa-solid fa-ban"></i></a>
                                        <?php endif; ?>
                                        <button onclick="confirmDelete(<?= e($review['id']) ?>)" class="p-1.5 text-gray-400 hover:text-red-600 transition-colors" title="Supprimer"><i class="fa-solid fa-trash"></i></button>
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
                'baseUrl' => url('admin/reviews?'),
            ]) ?>
        </div>
    </main>
</div>
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet avis ?')) {
        window.location.href = '<?= url('admin/reviews') ?>/' + id + '/delete';
    }
}
</script>
