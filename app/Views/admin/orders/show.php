<?php
$order = $order ?? [];
$items = $order['items'] ?? [];
$timeline = $order['timeline'] ?? [];
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
            <a href="<?= url('admin/orders') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium bg-primary-red/10 text-primary-red transition-colors"><i class="fa-solid fa-truck w-5 text-center"></i> Commandes</a>
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
                    <a href="<?= url('admin/orders') ?>" class="text-sm text-gray-500 hover:text-primary-red transition-colors mb-1 inline-block"><i class="fa-solid fa-arrow-left mr-1"></i> Retour aux commandes</a>
                    <h1 class="text-2xl font-bold text-gray-800">Commande #<?= e($order['order_number'] ?? $order['id']) ?></h1>
                    <p class="text-sm text-gray-500">Passée le <?= formatDate($order['created_at'] ?? '', 'd M Y à H:i') ?></p>
                </div>
                <div class="flex gap-2">
                    <a href="<?= url('admin/orders/' . e($order['id']) . '/invoice') ?>" class="border border-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors"><i class="fa-solid fa-file-pdf mr-1.5"></i> Télécharger la facture</a>
                    <a href="<?= url('admin/orders/' . e($order['id']) . '/print') ?>" class="border border-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors"><i class="fa-solid fa-print mr-1.5"></i> Imprimer</a>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Articles commandés</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-gray-50 text-left">
                                        <th class="px-4 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Produit</th>
                                        <th class="px-4 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">SKU</th>
                                        <th class="px-4 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Prix</th>
                                        <th class="px-4 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Qté</th>
                                        <th class="px-4 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Sous-total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <?php if (!empty($item['image'])): ?>
                                                <img src="<?= asset('images/' . e($item['image'])) ?>" alt="<?= e($item['name']) ?>" class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                                                <?php else: ?>
                                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400"><i class="fa-solid fa-image"></i></div>
                                                <?php endif; ?>
                                                <span class="font-medium text-gray-800"><?= e($item['name']) ?></span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-500"><?= e($item['sku'] ?? 'N/A') ?></td>
                                        <td class="px-4 py-3 text-gray-700"><?= formatPrice($item['price'] ?? 0) ?></td>
                                        <td class="px-4 py-3 text-gray-700"><?= $item['quantity'] ?? 1 ?></td>
                                        <td class="px-4 py-3 font-medium text-gray-800"><?= formatPrice(($item['price'] ?? 0) * ($item['quantity'] ?? 1)) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <?php if (!empty($order['subtotal'])): ?>
                                    <tr><td colspan="4" class="px-4 py-2 text-right text-sm text-gray-500">Sous-total</td><td class="px-4 py-2 font-medium text-gray-700"><?= formatPrice($order['subtotal']) ?></td></tr>
                                    <?php endif; ?>
                                    <?php if (!empty($order['discount'])): ?>
                                    <tr><td colspan="4" class="px-4 py-2 text-right text-sm text-gray-500">Réduction</td><td class="px-4 py-2 font-medium text-red-600">-<?= formatPrice($order['discount']) ?></td></tr>
                                    <?php endif; ?>
                                    <?php if (!empty($order['shipping_cost'])): ?>
                                    <tr><td colspan="4" class="px-4 py-2 text-right text-sm text-gray-500">Livraison</td><td class="px-4 py-2 font-medium text-gray-700"><?= formatPrice($order['shipping_cost']) ?></td></tr>
                                    <?php endif; ?>
                                    <?php if (!empty($order['tax'])): ?>
                                    <tr><td colspan="4" class="px-4 py-2 text-right text-sm text-gray-500">TVA</td><td class="px-4 py-2 font-medium text-gray-700"><?= formatPrice($order['tax']) ?></td></tr>
                                    <?php endif; ?>
                                    <tr><td colspan="4" class="px-4 py-3 text-right text-sm font-bold text-gray-800">Total</td><td class="px-4 py-3 font-bold text-gray-800 text-base"><?= formatPrice($order['total'] ?? 0) ?></td></tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Mise à jour du statut</h2>
                        <form method="POST" action="<?= url('admin/orders/' . e($order['id']) . '/status') ?>" class="flex flex-wrap items-end gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Statut de la commande</label>
                                <select name="order_status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                                    <option value="pending" <?= ($order['order_status'] ?? '') === 'pending' ? 'selected' : '' ?>>En attente</option>
                                    <option value="processing" <?= ($order['order_status'] ?? '') === 'processing' ? 'selected' : '' ?>>En cours</option>
                                    <option value="shipped" <?= ($order['order_status'] ?? '') === 'shipped' ? 'selected' : '' ?>>Expédiée</option>
                                    <option value="delivered" <?= ($order['order_status'] ?? '') === 'delivered' ? 'selected' : '' ?>>Livrée</option>
                                    <option value="cancelled" <?= ($order['order_status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Annulée</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Statut du paiement</label>
                                <select name="payment_status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                                    <option value="pending" <?= ($order['payment_status'] ?? '') === 'pending' ? 'selected' : '' ?>>En attente</option>
                                    <option value="paid" <?= ($order['payment_status'] ?? '') === 'paid' ? 'selected' : '' ?>>Payé</option>
                                    <option value="failed" <?= ($order['payment_status'] ?? '') === 'failed' ? 'selected' : '' ?>>Échoué</option>
                                    <option value="refunded" <?= ($order['payment_status'] ?? '') === 'refunded' ? 'selected' : '' ?>>Remboursé</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-primary-red text-white px-5 py-2 rounded-lg text-sm font-medium hover:opacity-90 transition-all">Mettre à jour</button>
                        </form>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Chronologie</h2>
                        <div class="space-y-0">
                            <?php if (empty($timeline)): ?>
                            <p class="text-sm text-gray-400 text-center py-4">Aucun événement enregistré</p>
                            <?php else: ?>
                            <?php foreach ($timeline as $event): ?>
                            <div class="flex gap-4 pb-4 relative">
                                <div class="flex flex-col items-center">
                                    <div class="w-3 h-3 rounded-full border-2 border-primary-red bg-white z-10"></div>
                                    <div class="w-0.5 flex-1 bg-gray-200 mt-1"></div>
                                </div>
                                <div class="flex-1 -mt-1">
                                    <p class="text-sm font-medium text-gray-800"><?= e($event['status_label'] ?? $event['status']) ?></p>
                                    <p class="text-xs text-gray-400"><?= formatDate($event['created_at'] ?? $event['date'] ?? '', 'd M Y à H:i') ?></p>
                                    <?php if (!empty($event['notes'])): ?>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= e($event['notes']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-3 h-3 rounded-full bg-gray-300 z-10"></div>
                                </div>
                                <div class="flex-1 -mt-1">
                                    <p class="text-sm text-gray-400">Commande créée</p>
                                    <p class="text-xs text-gray-400"><?= formatDate($order['created_at'] ?? '', 'd M Y à H:i') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Informations de facturation</h2>
                        <div class="space-y-2 text-sm">
                            <p class="text-gray-800 font-medium"><?= e($order['billing_name'] ?? 'N/A') ?></p>
                            <p class="text-gray-500"><?= e($order['billing_email'] ?? '') ?></p>
                            <p class="text-gray-500"><?= e($order['billing_phone'] ?? '') ?></p>
                            <p class="text-gray-500"><?= e($order['billing_address'] ?? '') ?></p>
                            <p class="text-gray-500"><?= e($order['billing_city'] ?? '') ?><?= $order['billing_pincode'] ? ' - ' . e($order['billing_pincode']) : '' ?></p>
                            <p class="text-gray-500"><?= e($order['billing_state'] ?? '') ?><?= $order['billing_country'] ? ', ' . e($order['billing_country']) : '' ?></p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Adresse de livraison</h2>
                        <div class="space-y-2 text-sm">
                            <p class="text-gray-800 font-medium"><?= e($order['shipping_name'] ?? $order['billing_name'] ?? 'N/A') ?></p>
                            <p class="text-gray-500"><?= e($order['shipping_email'] ?? $order['billing_email'] ?? '') ?></p>
                            <p class="text-gray-500"><?= e($order['shipping_phone'] ?? $order['billing_phone'] ?? '') ?></p>
                            <p class="text-gray-500"><?= e($order['shipping_address'] ?? $order['billing_address'] ?? '') ?></p>
                            <p class="text-gray-500"><?= e($order['shipping_city'] ?? $order['billing_city'] ?? '') ?><?= $order['shipping_pincode'] ? ' - ' . e($order['shipping_pincode']) : '' ?></p>
                            <p class="text-gray-500"><?= e($order['shipping_state'] ?? $order['billing_state'] ?? '') ?><?= $order['shipping_country'] ? ', ' . e($order['shipping_country']) : '' ?></p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Informations de paiement</h2>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Méthode</span>
                                <span class="text-gray-800 font-medium"><?= e($order['payment_method'] ?? 'N/A') ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Transaction</span>
                                <span class="text-gray-800 font-medium"><?= e($order['transaction_id'] ?? 'N/A') ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Statut</span>
                                <span>
                                    <?php $ps = $order['payment_status'] ?? ''; ?>
                                    <?php if ($ps === 'paid'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Payé</span>
                                    <?php elseif ($ps === 'pending'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">En attente</span>
                                    <?php elseif ($ps === 'failed'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Échoué</span>
                                    <?php elseif ($ps === 'refunded'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">Remboursé</span>
                                    <?php else: ?>
                                    <span class="text-gray-500"><?= e($ps ?: 'N/A') ?></span>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-gray-100">
                                <span class="text-gray-800 font-bold">Total payé</span>
                                <span class="text-gray-800 font-bold"><?= formatPrice($order['total'] ?? 0) ?></span>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($order['notes'])): ?>
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Notes</h2>
                        <p class="text-sm text-gray-600"><?= nl2br(e($order['notes'])) ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>
