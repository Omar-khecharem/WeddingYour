<?php startSection('content') ?>
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mt-8">
        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
            Bonjour, <?= e($user['name']) ?> !
        </h1>
        <p class="mt-2 text-sm text-gray-500">
            Bienvenue dans votre espace client. Gérez vos commandes, vos adresses et vos informations personnelles.
        </p>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total commandes</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total dépensé</p>
                    <p class="text-2xl font-bold text-gray-900"><?= formatPrice(0) ?></p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-rose-100 text-rose-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Liste de souhaits</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Commandes en attente</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-10">
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Dernières commandes</h2>
            </div>
            <div class="overflow-x-auto">
                <?php if (empty($recentOrders)): ?>
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="mt-4 text-sm text-gray-500">Aucune commande pour le moment.</p>
                        <a href="<?= url('products') ?>" class="mt-4 inline-block rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                            Découvrir nos produits
                        </a>
                    </div>
                <?php else: ?>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">N° commande</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Paiement</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($recentOrders as $order): ?>
                                <tr class="transition-colors hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">#<?= e($order['order_number']) ?></td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500"><?= formatDate($order['created_at']) ?></td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900"><?= formatPrice($order['total']) ?></td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <?php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'shipped' => 'bg-purple-100 text-purple-800',
                                            'delivered' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'En attente',
                                            'processing' => 'En cours',
                                            'shipped' => 'Expédiée',
                                            'delivered' => 'Livrée',
                                            'cancelled' => 'Annulée',
                                        ];
                                        $color = $statusColors[$order['order_status']] ?? 'bg-gray-100 text-gray-800';
                                        $label = $statusLabels[$order['order_status']] ?? $order['order_status'];
                                        ?>
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium <?= $color ?>"><?= $label ?></span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <?php
                                        $paymentColors = ['paid' => 'bg-green-100 text-green-800', 'pending' => 'bg-yellow-100 text-yellow-800', 'failed' => 'bg-red-100 text-red-800', 'refunded' => 'bg-gray-100 text-gray-800'];
                                        $paymentLabels = ['paid' => 'Payé', 'pending' => 'En attente', 'failed' => 'Échoué', 'refunded' => 'Remboursé'];
                                        $pColor = $paymentColors[$order['payment_status']] ?? 'bg-gray-100 text-gray-800';
                                        $pLabel = $paymentLabels[$order['payment_status']] ?? $order['payment_status'];
                                        ?>
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium <?= $pColor ?>"><?= $pLabel ?></span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                        <a href="<?= url('account/orders/' . e($order['order_number'])) ?>" class="font-medium text-indigo-600 hover:text-indigo-900">Voir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="border-t border-gray-200 px-6 py-4">
                        <a href="<?= url('account/orders') ?>" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">Voir toutes mes commandes &rarr;</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="mt-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900"><?= e($user['name']) ?></p>
                <p class="text-sm text-gray-500"><?= e($user['email']) ?></p>
                <?php if (!empty($user['phone'])): ?>
                    <p class="text-sm text-gray-500"><?= e($user['phone']) ?></p>
                <?php endif; ?>
                <?php $memberSince = $user['created_at'] ?? $user['registered_at'] ?? ''; ?>
                <?php if ($memberSince): ?><p class="mt-1 text-xs text-gray-400">Membre depuis le <?= formatDate($memberSince) ?></p><?php endif; ?>
            </div>
            <a href="<?= url('account/profile') ?>" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">Modifier</a>
        </div>
    </div>
</div>
<?php endSection() ?>
