<?php


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
        'pending'    => 'Pending',
        'confirmed'  => 'Confirmed',
        'processing' => 'Processing',
        'shipped'    => 'Shipped',
        'delivered'  => 'Delivered',
        'cancelled'  => 'Cancelled',
        'refunded'   => 'Refunded',
        default      => $status,
    };
};

$timelineSteps = [
    'pending'    => ['label' => 'Order placed',      'icon' => 'fa-file-invoice',     'key' => 'created_at'],
    'confirmed'  => ['label' => 'Confirmed',             'icon' => 'fa-check-circle',     'key' => 'confirmed_at'],
    'processing' => ['label' => 'Processing','icon' => 'fa-spinner',          'key' => 'processed_at'],
    'shipped'    => ['label' => 'Shipped',              'icon' => 'fa-truck',            'key' => 'shipped_at'],
    'delivered'  => ['label' => 'Delivered',                'icon' => 'fa-circle-check',     'key' => 'delivered_at'],
];

$currentStatus = $order['order_status'] ?? 'pending';
$reached = false;
?>

<?= component('Breadcrumb', ['crumbs' => [
    ['label' => 'My Account', 'url' => url('account')],
    ['label' => 'My Orders', 'url' => url('account/orders')],
    ['label' => 'Order #' . ($order['order_number'] ?? ''), 'url' => null],
]]) ?>

<?php startSection('content') ?>

<!-- Header -->
<div class="bg-white rounded-xl border border-gray-200 p-6 lg:p-8 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary-red/10 flex items-center justify-center text-primary-red">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Order #<?= e($order['order_number'] ?? '') ?></h1>
                <p class="text-sm text-gray-500">Placed on <?= formatDate($order['created_at'] ?? '', 'd/m/Y \a\t H:i') ?></p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-block text-sm font-bold px-3 py-1.5 rounded-full border <?= $statusBadge($currentStatus) ?>">
                <?= $statusLabel($currentStatus) ?>
            </span>
            <a href="<?= url('account/orders/' . $order['id'] . '/invoice') ?>"
               class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fa-solid fa-file-pdf"></i> Download Invoice
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Colonne principale -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Timeline -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="font-bold text-gray-900 mb-5">Order Tracking</h2>
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
                        <p class="text-xs text-gray-500 mt-0.5"><?= formatDate($timestamp, 'd/m/Y \a\t H:i') ?></p>
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
                            <?= $currentStatus === 'cancelled' ? 'Cancelled' : 'Refunded' ?>
                        </p>
                        <?php if (!empty($order['cancelled_at'])): ?>
                        <p class="text-xs text-gray-500 mt-0.5"><?= formatDate($order['cancelled_at'], 'd/m/Y \a\t H:i') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Articles -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="font-bold text-gray-900 mb-5">Ordered Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="text-left px-3 py-3 font-semibold text-gray-600">Product</th>
                            <th class="text-left px-3 py-3 font-semibold text-gray-600">SKU</th>
                            <th class="text-center px-3 py-3 font-semibold text-gray-600">Qty</th>
                            <th class="text-right px-3 py-3 font-semibold text-gray-600">Unit Price</th>
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
                                        <p class="text-xs text-gray-500 mt-0.5">Variant: <?= e($item['variant_name']) ?></p>
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
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold text-gray-900"><?= formatPrice((float)($order['subtotal'] ?? 0)) ?></span>
                    </div>
                    <?php if (!empty($order['discount']) && (float)$order['discount'] > 0): ?>
                    <div class="flex justify-between text-green-600">
                        <span>Discount</span>
                        <span class="font-semibold">-<?= formatPrice((float)$order['discount']) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($order['coupon_code'])): ?>
                    <div class="flex justify-between text-gray-500 text-xs">
                        <span>Coupon Code</span>
                        <span><?= e($order['coupon_code']) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold text-gray-900">
                            <?= (float)($order['shipping_cost'] ?? 0) > 0 ? formatPrice((float)$order['shipping_cost']) : '<span class="text-green-600">Free</span>' ?>
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax</span>
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

    <!-- Side column -->
    <div class="space-y-6">

        <!-- Billing Address -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-file-invoice text-gray-400"></i> Billing
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
                <span class="text-gray-600">Payment</span>
                <span class="font-semibold text-gray-900"><?= e($order['payment_method_name'] ?? '') ?></span>
            </div>
            <div class="flex items-center justify-between text-sm mt-1">
                <span class="text-gray-600">Status</span>
                <span class="font-semibold <?= in_array($order['payment_status'] ?? '', ['paid', 'completed']) ? 'text-green-600' : 'text-red-500' ?>">
                    <?php
                    $ps = $order['payment_status'] ?? '';
                    echo match ($ps) {
                        'paid', 'completed' => 'Paid',
                        'unpaid' => 'Unpaid',
                        'refunded' => 'Refunded',
                        'pending' => 'Pending',
                        default => $ps,
                    };
                    ?>
                </span>
            </div>
        </div>

        <!-- Shipping Address -->
        <?php if (!empty($order['shipping_name']) || !empty($order['shipping_address'])): ?>
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-truck text-gray-400"></i> Shipping
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
