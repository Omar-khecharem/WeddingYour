<?php
/**
 * Détail d'une commande
 *
 * Variables :
 *   $order – tableau complet de la commande
 *     - order_number, created_at, total, subtotal, shipping_cost, tax, discount
 *     - order_status, payment_status, payment_method_name
 *     - billing_name, billing_email, billing_phone, billing_address, billing_address2, billing_city, billing_state, billing_postal_code
 *     - shipping_name, shipping_phone, shipping_address, shipping_address2, shipping_city, shipping_state, shipping_postal_code
 *     - notes, coupon_code
 *     - items[] : product_name, product_sku, variant_name, quantity, unit_price, total_price, image
 */

$order = $order ?? [];

$statusBadge = function (string $status): string {
    return match ($status) {
        'pending'    => 'bg-yellow-100 text-yellow-700 border-yellow-300',
        'confirmed'  => 'bg-blue-100 text-blue-700 border-blue-300',
        'processing' => 'bg-indigo-100 text-indigo-700 border-indigo-300',
        'shipped'    => 'bg-purple-100 text-purple-700 border-purple-300',
        'delivered'  => 'bg-green-100 text-green-700 border-green-300',
        'cancelled'  => 'bg-red-100 text-red-700 border-red-300',
        'refunded'   => 'bg-gray-100 text-gray-600 border-gray-300',
        default      => 'bg-gray-100 text-gray-600 border-gray-300',
    };
};

$statusLabel = function (string $status): string {
    return match ($status) {
        'pending'    => 'En attente',
        'confirmed'  => 'Confirmée',
        'processing' => 'En cours',
        'shipped'    => 'Expédiée',
        'delivered'  => 'Livrée',
        'cancelled'  => 'Annulée',
        'refunded'   => 'Remboursée',
        default      => $status,
    };
};

$timelineSteps = [
    'pending'    => ['label' => 'Commande passée',      'icon' => 'fa-file-invoice',     'key' => 'created_at'],
    'confirmed'  => ['label' => 'Confirmée',             'icon' => 'fa-check-circle',     'key' => 'confirmed_at'],
    'processing' => ['label' => 'En cours de traitement','icon' => 'fa-spinner',          'key' => 'processed_at'],
    'shipped'    => ['label' => 'Expédiée',              'icon' => 'fa-truck',            'key' => 'shipped_at'],
    'delivered'  => ['label' => 'Livrée',                'icon' => 'fa-circle-check',     'key' => 'delivered_at'],
];

$currentStatus = $order['order_status'] ?? 'pending';
$reached = false;
?>

<?= component('Breadcrumb', ['crumbs' => [
    ['label' => 'Mon compte', 'url' => url('account')],
    ['label' => 'Mes commandes', 'url' => url('account/orders')],
    ['label' => 'Commande #' . ($order['order_number'] ?? ''), 'url' => null],
]]) ?>

<?php startSection('content') ?>

<!-- En-tête -->
<div class="bg-white rounded-xl border border-gray-200 p-6 lg:p-8 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary-red/10 flex items-center justify-center text-primary-red">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Commande #<?= e($order['order_number'] ?? '') ?></h1>
                <p class="text-sm text-gray-500">Passée le <?= formatDate($order['created_at'] ?? '', 'd/m/Y à H:i') ?></p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-block text-sm font-bold px-3 py-1.5 rounded-full border <?= $statusBadge($currentStatus) ?>">
                <?= $statusLabel($currentStatus) ?>
            </span>
            <a href="<?= url('account/order/' . $order['id'] . '/invoice') ?>"
               class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fa-solid fa-file-pdf"></i> Télécharger la facture
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Colonne principale -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Timeline -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="font-bold text-gray-900 mb-5">Suivi de commande</h2>
            <div class="relative">
                <?php foreach ($timelineSteps as $status => $step):
                    $timestamp = $order[$step['key']] ?? null;
                    $isReached = !$reached && ($timestamp || $status === $currentStatus);
                    if ($status === $currentStatus) $reached = true;
                    $done = !empty($timestamp);
                    $active = $status === $currentStatus;
                ?>
                <div class="flex items-start gap-4 pb-6 last:pb-0 relative">
                    <?php if (!$done && !$active): ?>
                    <div class="w-8 h-8 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center flex-shrink-0 z-10">
                        <i class="fa-regular fa-circle text-gray-300 text-xs"></i>
                    </div>
                    <?php elseif ($active): ?>
                    <div class="w-8 h-8 rounded-full bg-primary-red flex items-center justify-center flex-shrink-0 z-10 shadow-md">
                        <i class="fa-solid <?= $step['icon'] ?> text-white text-xs"></i>
                    </div>
                    <?php else: ?>
                    <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center flex-shrink-0 z-10">
                        <i class="fa-solid fa-check text-white text-xs"></i>
                    </div>
                    <?php endif; ?>

                    <?php if ($status !== array_key_last($timelineSteps)): ?>
                    <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-gray-200 -translate-x-1/2"></div>
                    <?php endif; ?>

                    <div class="flex-1 min-w-0 pt-1">
                        <p class="text-sm font-semibold <?= $done || $active ? 'text-gray-900' : 'text-gray-400' ?>">
                            <?= $step['label'] ?>
                        </p>
                        <?php if ($timestamp): ?>
                        <p class="text-xs text-gray-500 mt-0.5"><?= formatDate($timestamp, 'd/m/Y à H:i') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php if (in_array($currentStatus, ['cancelled', 'refunded'])): ?>
                <div class="flex items-start gap-4 pt-2">
                    <div class="w-8 h-8 rounded-full <?= $currentStatus === 'cancelled' ? 'bg-red-500' : 'bg-gray-500' ?> flex items-center justify-center flex-shrink-0 z-10">
                        <i class="fa-solid fa-xmark text-white text-xs"></i>
                    </div>
                    <div class="flex-1 pt-1">
                        <p class="text-sm font-semibold text-gray-900">
                            <?= $currentStatus === 'cancelled' ? 'Annulée' : 'Remboursée' ?>
                        </p>
                        <?php if (!empty($order['cancelled_at'])): ?>
                        <p class="text-xs text-gray-500 mt-0.5"><?= formatDate($order['cancelled_at'], 'd/m/Y à H:i') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Articles -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="font-bold text-gray-900 mb-5">Articles commandés</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="text-left px-3 py-3 font-semibold text-gray-600">Produit</th>
                            <th class="text-left px-3 py-3 font-semibold text-gray-600">SKU</th>
                            <th class="text-center px-3 py-3 font-semibold text-gray-600">Qté</th>
                            <th class="text-right px-3 py-3 font-semibold text-gray-600">Prix unitaire</th>
                            <th class="text-right px-3 py-3 font-semibold text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($order['items'] ?? []) as $item): ?>
                        <tr class="border-b border-gray-100">
                            <td class="px-3 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-14 h-14 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                        <img src="<?= e($item['image'] ?? asset('images/placeholder.png')) ?>"
                                             alt="<?= e($item['product_name'] ?? '') ?>"
                                             class="w-full h-full object-cover" loading="lazy">
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900"><?= e($item['product_name'] ?? '') ?></p>
                                        <?php if (!empty($item['variant_name'])): ?>
                                        <p class="text-xs text-gray-500 mt-0.5">Variante : <?= e($item['variant_name']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-4 text-gray-500 text-xs"><?= e($item['product_sku'] ?? '') ?></td>
                            <td class="px-3 py-4 text-center text-gray-900"><?= (int)($item['quantity'] ?? 0) ?></td>
                            <td class="px-3 py-4 text-right text-gray-900"><?= formatPrice((float)($item['unit_price'] ?? 0)) ?></td>
                            <td class="px-3 py-4 text-right font-semibold text-gray-900"><?= formatPrice((float)($item['total_price'] ?? 0)) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Totaux -->
            <div class="flex justify-end mt-4">
                <div class="w-full sm:w-72 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sous-total</span>
                        <span class="font-semibold text-gray-900"><?= formatPrice((float)($order['subtotal'] ?? 0)) ?></span>
                    </div>
                    <?php if (!empty($order['discount']) && (float)$order['discount'] > 0): ?>
                    <div class="flex justify-between text-green-600">
                        <span>Réduction</span>
                        <span class="font-semibold">-<?= formatPrice((float)$order['discount']) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($order['coupon_code'])): ?>
                    <div class="flex justify-between text-gray-500 text-xs">
                        <span>Code promo</span>
                        <span><?= e($order['coupon_code']) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Livraison</span>
                        <span class="font-semibold text-gray-900">
                            <?= (float)($order['shipping_cost'] ?? 0) > 0 ? formatPrice((float)$order['shipping_cost']) : '<span class="text-green-600">Gratuite</span>' ?>
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">TVA</span>
                        <span class="font-semibold text-gray-900"><?= formatPrice((float)($order['tax'] ?? 0)) ?></span>
                    </div>
                    <hr class="border-gray-200">
                    <div class="flex justify-between text-base">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-extrabold text-primary-red"><?= formatPrice((float)($order['total'] ?? 0)) ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Colonne latérale -->
    <div class="space-y-6">

        <!-- Adresse de facturation -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-file-invoice text-gray-400"></i> Facturation
            </h3>
            <div class="text-sm text-gray-600 space-y-1">
                <p class="font-semibold text-gray-900"><?= e($order['billing_name'] ?? '') ?></p>
                <p><?= e($order['billing_email'] ?? '') ?></p>
                <p><?= e($order['billing_phone'] ?? '') ?></p>
                <p class="mt-2"><?= e($order['billing_address'] ?? '') ?></p>
                <?php if (!empty($order['billing_address2'])): ?>
                <p><?= e($order['billing_address2']) ?></p>
                <?php endif; ?>
                <p><?= e($order['billing_city'] ?? '') ?>, <?= e($order['billing_state'] ?? '') ?> <?= e($order['billing_postal_code'] ?? '') ?></p>
            </div>

            <hr class="border-gray-200 my-3">

            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">Paiement</span>
                <span class="font-semibold text-gray-900"><?= e($order['payment_method_name'] ?? '') ?></span>
            </div>
            <div class="flex items-center justify-between text-sm mt-1">
                <span class="text-gray-600">Statut</span>
                <span class="font-semibold <?= ($order['payment_status'] ?? '') === 'paid' ? 'text-green-600' : 'text-red-500' ?>">
                    <?php
                    $ps = $order['payment_status'] ?? '';
                    echo match ($ps) {
                        'paid' => 'Payé',
                        'unpaid' => 'Impayé',
                        'refunded' => 'Remboursé',
                        'pending' => 'En attente',
                        default => $ps,
                    };
                    ?>
                </span>
            </div>
        </div>

        <!-- Adresse de livraison -->
        <?php if (!empty($order['shipping_name']) || !empty($order['shipping_address'])): ?>
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-truck text-gray-400"></i> Livraison
            </h3>
            <div class="text-sm text-gray-600 space-y-1">
                <p class="font-semibold text-gray-900"><?= e($order['shipping_name'] ?? '') ?></p>
                <p><?= e($order['shipping_phone'] ?? '') ?></p>
                <p class="mt-2"><?= e($order['shipping_address'] ?? '') ?></p>
                <?php if (!empty($order['shipping_address2'])): ?>
                <p><?= e($order['shipping_address2']) ?></p>
                <?php endif; ?>
                <p><?= e($order['shipping_city'] ?? '') ?>, <?= e($order['shipping_state'] ?? '') ?> <?= e($order['shipping_postal_code'] ?? '') ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Notes -->
        <?php if (!empty($order['notes'])): ?>
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-note-sticky text-gray-400"></i> Notes
            </h3>
            <p class="text-sm text-gray-600"><?= nl2br(e($order['notes'])) ?></p>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php endSection() ?>
