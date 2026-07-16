<?php


$orders = $orders ?? [];
$pagination = $pagination ?? [];

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

$paymentStatusLabel = function (string $status): string {
    return match ($status) {
        'paid'    => 'Paid',
        'unpaid'  => 'Unpaid',
        'refunded' => 'Refunded',
        'pending' => 'Pending',
        default   => $status,
    };
};
?>

<?= component('Breadcrumb', ['crumbs' => [
    ['label' => 'My Account', 'url' => url('account')],
    ['label' => 'My Orders', 'url' => null],
]]) ?>

<?php startSection('content') ?>

<div class="bg-white rounded-xl border border-gray-200 p-6 lg:p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-full bg-primary-red/10 flex items-center justify-center text-primary-red">
            <i class="fa-solid fa-box"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">My Orders</h1>
            <p class="text-sm text-gray-500">View your order history</p>
        </div>
    </div>

    <?php if (empty($orders)): ?>
    <div class="text-center py-16">
        <div class="text-5xl text-gray-300 mb-5">
            <i class="fa-solid fa-receipt"></i>
        </div>
        <h2 class="text-lg font-bold text-gray-700 mb-2">No orders</h2>
        <p class="text-sm text-gray-500 mb-6">You haven't placed any orders yet.</p>
        <a href="<?= url('products') ?>" class="maroon-btn">
            <i class="fa-solid fa-bag-shopping mr-1.5"></i> Browse Products
        </a>
    </div>
    <?php else: ?>

    <!-- Desktop table -->
    <div class="hidden sm:block overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Order #</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Date</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Total</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Status</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Payment</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-4 py-4 font-semibold text-gray-900">
                        #<?= e($order['order_number']) ?>
                    </td>
                    <td class="px-4 py-4 text-gray-600">
                        <?= formatDate($order['created_at'], 'd/m/Y') ?>
                    </td>
                    <td class="px-4 py-4 font-semibold text-gray-900">
                        <?= formatPrice((float)($order['total'] ?? 0)) ?>
                    </td>
                    <td class="px-4 py-4">
                        <span class="inline-block text-xs font-bold px-2.5 py-1 rounded-full border <?= $statusBadge($order['order_status'] ?? '') ?>">
                            <?= $statusLabel($order['order_status'] ?? '') ?>
                        </span>
                    </td>
                    <td class="px-4 py-4 text-gray-600">
                        <?= $paymentStatusLabel($order['payment_status'] ?? '') ?>
                        <?php if (!empty($order['payment_method_name'])): ?>
                        <span class="text-xs text-gray-400 block"><?= e($order['payment_method_name']) ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-4 text-right">
                        <a href="<?= url('account/orders/' . $order['id']) ?>"
                           class="inline-flex items-center gap-1.5 text-primary-red hover:text-primary-red/80 font-semibold text-xs transition-colors">
                            View <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Mobile cards -->
    <div class="sm:hidden divide-y divide-gray-100 border-t border-gray-100">
        <?php foreach ($orders as $order): ?>
        <a href="<?= url('account/orders/' . $order['id']) ?>" class="block px-1 py-4 hover:bg-gray-50/50 transition-colors">
            <div class="flex items-center justify-between mb-2">
                <span class="font-bold text-gray-900 text-sm">#<?= e($order['order_number']) ?></span>
                <span class="inline-block text-xs font-bold px-2.5 py-1 rounded-full border <?= $statusBadge($order['order_status'] ?? '') ?>">
                    <?= $statusLabel($order['order_status'] ?? '') ?>
                </span>
            </div>
            <div class="flex items-center justify-between text-xs text-gray-500">
                <span><?= formatDate($order['created_at'], 'd/m/Y') ?></span>
                <span class="font-semibold text-gray-900"><?= formatPrice((float)($order['total'] ?? 0)) ?></span>
            </div>
            <?php if (!empty($order['payment_method_name'])): ?>
            <div class="mt-1.5 text-xs text-gray-400">
                Payment: <?= $paymentStatusLabel($order['payment_status'] ?? '') ?> &middot; <?= e($order['payment_method_name']) ?>
            </div>
            <?php endif; ?>
            <div class="mt-2 flex items-center text-xs font-semibold text-primary-red">
                View Details <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
            </div>
        </a>
        <?php endforeach; ?>
    </div>

    <?php if (($pagination['totalPages'] ?? 1) > 1): ?>
    <div class="mt-6">
        <?= component('Pagination', [
            'currentPage' => (int)($pagination['currentPage'] ?? 1),
            'totalPages'  => (int)($pagination['totalPages'] ?? 1),
            'baseUrl'     => url('account/orders') . '?',
        ]) ?>
    </div>
    <?php endif; ?>

    <?php endif; ?>
</div>

<?php endSection() ?>
