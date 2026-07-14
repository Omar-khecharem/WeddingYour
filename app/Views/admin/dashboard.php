<?php
$stats = $stats ?? [];
$recentOrders = $stats['recent_orders'] ?? [];
?>
<div class="flex h-screen overflow-hidden bg-gray-50">
    <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 overflow-y-auto hidden lg:block">
        <div class="p-5 border-b border-gray-200">
            <a href="<?= url('admin') ?>" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-primary-red flex items-center justify-center text-white font-bold text-sm">A</div>
                <div>
                    <span class="font-bold text-gray-800 text-sm">Administration</span>
                    <p class="text-xs text-gray-400">Panneau de contrôle</p>
                </div>
            </a>
        </div>
        <nav class="p-4 space-y-1">
            <a href="<?= url('admin') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium bg-primary-red/10 text-primary-red transition-colors">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i> Tableau de bord
            </a>
            <a href="<?= url('admin/products') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                <i class="fa-solid fa-box w-5 text-center"></i> Produits
            </a>
            <a href="<?= url('admin/orders') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                <i class="fa-solid fa-truck w-5 text-center"></i> Commandes
            </a>
            <a href="<?= url('admin/users') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                <i class="fa-solid fa-users w-5 text-center"></i> Clients
            </a>
            <a href="<?= url('admin/reviews') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                <i class="fa-solid fa-star w-5 text-center"></i> Avis
            </a>
            <a href="<?= url('admin/coupons') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                <i class="fa-solid fa-tag w-5 text-center"></i> Coupons
            </a>
            <a href="<?= url('admin/pages') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                <i class="fa-solid fa-file w-5 text-center"></i> Pages
            </a>
            <hr class="my-3 border-gray-200">
            <a href="<?= url('admin/settings') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                <i class="fa-solid fa-gear w-5 text-center"></i> Paramètres
            </a>
            <a href="<?= url('admin/logs') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                <i class="fa-solid fa-list w-5 text-center"></i> Logs
            </a>
        </nav>
    </aside>
    <main class="flex-1 overflow-y-auto">
        <div class="max-w-[1400px] mx-auto py-6 px-4 lg:px-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>
                    <p class="text-sm text-gray-500">Bienvenue, <?= e($authUser['name'] ?? 'Admin') ?></p>
                </div>
                <div class="flex gap-3">
                    <a href="<?= url('') ?>" class="border border-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors" target="_blank">
                        <i class="fa-solid fa-eye mr-1.5"></i> Voir le site
                    </a>
                    <a href="<?= url('admin/clear-cache') ?>" class="bg-primary-red text-white px-4 py-2 rounded-lg text-sm font-medium hover:opacity-90 transition-all">
                        <i class="fa-solid fa-eraser mr-1.5"></i> Vider le cache
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm text-gray-500 font-medium">Revenu total</p>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800"><?= formatPrice($stats['total_revenue'] ?? 0) ?></p>
                    <p class="text-xs text-green-600 mt-1"><i class="fa-solid fa-arrow-up mr-1"></i> +<?= $stats['revenue_growth'] ?? 0 ?>% vs mois dernier</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm text-gray-500 font-medium">Commandes</p>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600"><i class="fa-solid fa-box"></i></div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800"><?= $stats['total_orders'] ?? 0 ?></p>
                    <p class="text-xs text-gray-500 mt-1">Total des commandes</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm text-gray-500 font-medium">Clients</p>
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600"><i class="fa-solid fa-users"></i></div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800"><?= $stats['total_users'] ?? 0 ?></p>
                    <p class="text-xs text-gray-500 mt-1">Comptes enregistrés</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm text-gray-500 font-medium">Produits</p>
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600"><i class="fa-solid fa-cube"></i></div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800"><?= $stats['total_products'] ?? 0 ?></p>
                    <p class="text-xs text-gray-500 mt-1">Produits en catalogue</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm text-gray-500 font-medium">En attente</p>
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-600"><i class="fa-solid fa-clock"></i></div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800"><?= $stats['pending_orders'] ?? 0 ?></p>
                    <p class="text-xs text-yellow-600 mt-1">Commandes en attente</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm text-gray-500 font-medium">Stock faible</p>
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center text-red-600"><i class="fa-solid fa-exclamation-triangle"></i></div>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800"><?= $stats['low_stock_count'] ?? 0 ?></p>
                    <p class="text-xs text-red-600 mt-1">Produits à réapprovisionner</p>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200">
                    <div class="flex items-center justify-between p-5 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800">Dernières commandes</h2>
                        <a href="<?= url('admin/orders') ?>" class="text-sm text-primary-red font-medium hover:underline">Voir tout</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left">
                                    <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Commande</th>
                                    <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Client</th>
                                    <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Date</th>
                                    <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Total</th>
                                    <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php if (empty($recentOrders)): ?>
                                <tr>
                                    <td colspan="5" class="px-5 py-8 text-center text-gray-400">Aucune commande récente</td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($recentOrders as $order): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3">
                                        <a href="<?= url('admin/orders/' . e($order['id'])) ?>" class="font-medium text-primary-red hover:underline">#<?= e($order['order_number'] ?? $order['id']) ?></a>
                                    </td>
                                    <td class="px-5 py-3 text-gray-700"><?= e($order['customer_name'] ?? $order['billing_name'] ?? 'N/A') ?></td>
                                    <td class="px-5 py-3 text-gray-500"><?= formatDate($order['created_at'] ?? '') ?></td>
                                    <td class="px-5 py-3 font-medium text-gray-800"><?= formatPrice($order['total'] ?? 0) ?></td>
                                    <td class="px-5 py-3">
                                        <?php $status = $order['order_status'] ?? ''; ?>
                                        <?php if ($status === 'confirmed' || $status === 'completed'): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Confirmée</span>
                                        <?php elseif ($status === 'pending'): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">En attente</span>
                                        <?php elseif ($status === 'processing'): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">En cours</span>
                                        <?php elseif ($status === 'shipped'): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">Expédiée</span>
                                        <?php elseif ($status === 'cancelled'): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Annulée</span>
                                        <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600"><?= e($status ?: 'N/A') ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Actions rapides</h2>
                    <div class="space-y-3">
                        <a href="<?= url('admin/products/create') ?>" class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-lg hover:bg-primary-red/5 hover:border-primary-red border border-gray-200 transition-all group">
                            <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform"><i class="fa-solid fa-plus"></i></div>
                            <div><p class="text-sm font-medium text-gray-800">Ajouter un produit</p><p class="text-xs text-gray-400">Nouveau produit au catalogue</p></div>
                        </a>
                        <a href="<?= url('admin/orders') ?>" class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-lg hover:bg-primary-red/5 hover:border-primary-red border border-gray-200 transition-all group">
                            <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform"><i class="fa-solid fa-truck"></i></div>
                            <div><p class="text-sm font-medium text-gray-800">Voir les commandes</p><p class="text-xs text-gray-400">Gérer les commandes clients</p></div>
                        </a>
                        <a href="<?= url('admin/coupons/create') ?>" class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-lg hover:bg-primary-red/5 hover:border-primary-red border border-gray-200 transition-all group">
                            <div class="w-9 h-9 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600 group-hover:scale-110 transition-transform"><i class="fa-solid fa-tag"></i></div>
                            <div><p class="text-sm font-medium text-gray-800">Créer un coupon</p><p class="text-xs text-gray-400">Nouvelle promotion</p></div>
                        </a>
                        <a href="<?= url('admin/users') ?>" class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-lg hover:bg-primary-red/5 hover:border-primary-red border border-gray-200 transition-all group">
                            <div class="w-9 h-9 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform"><i class="fa-solid fa-users"></i></div>
                            <div><p class="text-sm font-medium text-gray-800">Gérer les clients</p><p class="text-xs text-gray-400">Voir la base clients</p></div>
                        </a>
                        <a href="<?= url('admin/settings') ?>" class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-lg hover:bg-primary-red/5 hover:border-primary-red border border-gray-200 transition-all group">
                            <div class="w-9 h-9 rounded-lg bg-gray-200 flex items-center justify-center text-gray-600 group-hover:scale-110 transition-transform"><i class="fa-solid fa-gear"></i></div>
                            <div><p class="text-sm font-medium text-gray-800">Paramètres</p><p class="text-xs text-gray-400">Configurer le site</p></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
