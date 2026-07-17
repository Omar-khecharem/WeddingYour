<?php extend('layouts.main') ?>

<?php startSection('sidebar') ?>
<div class="space-y-1">
    <a href="<?= url('account') ?>"
       class="flex items-center gap-3 rounded-lg bg-white/10 px-3 py-2 text-sm font-medium text-white transition-all hover:bg-white/20">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        Dashboard
    </a>
    <a href="<?= url('account/profile') ?>"
       class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 transition-all hover:bg-white/10 hover:text-white">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        Profile
    </a>
    <a href="<?= url('account/orders') ?>"
       class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 transition-all hover:bg-white/10 hover:text-white">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        Orders
    </a>
    <a href="<?= url('account/addresses') ?>"
       class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 transition-all hover:bg-white/10 hover:text-white">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Addresses
    </a>
    <a href="<?= url('account/wishlist') ?>"
       class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 transition-all hover:bg-white/10 hover:text-white">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        Wishlist
    </a>
    <a href="<?= url('account/change-password') ?>"
       class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 transition-all hover:bg-white/10 hover:text-white">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>
        Password
    </a>
</div>
<div class="mt-6 border-t border-white/10 pt-4">
    <a href="<?= url('logout') ?>"
       class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 transition-all hover:bg-white/10 hover:text-white">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        Logout
    </a>
</div>
<?php endSection() ?>

<?php startSection('content') ?>
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <?= component('Breadcrumb', [
        'items' => [
            ['label' => 'Home', 'url' => url('/')],
            ['label' => 'My Account', 'url' => url('account')],
            ['label' => 'Dashboard'],
        ]
    ]) ?>

    <div class="mt-8">
        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
            Hello, <?= e($user['name']) ?> !
        </h1>
        <p class="mt-2 text-sm text-gray-500">
            Welcome to your account. Manage your orders, addresses and personal information.
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
                    <p class="text-sm font-medium text-gray-500">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $stats['total_orders'] ?></p>
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
                    <p class="text-sm font-medium text-gray-500">Total Spent</p>
                    <p class="text-2xl font-bold text-gray-900"><?= formatPrice($stats['total_spent']) ?></p>
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
                    <p class="text-sm font-medium text-gray-500">Wishlist</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $stats['wishlist_count'] ?></p>
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
                    <p class="text-sm font-medium text-gray-500">Pending Orders</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $stats['pending_orders'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-10">
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>
            </div>
            <div class="overflow-x-auto">
                <?php if (empty($recentOrders)): ?>
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="mt-4 text-sm text-gray-500">No orders yet.</p>
                        <a href="<?= url('products') ?>"
                           class="mt-4 inline-block rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                            Browse Products
                        </a>
                    </div>
                <?php else: ?>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Order #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Payment</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($recentOrders as $order): ?>
                                <tr class="transition-colors hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                        #<?= e($order['order_number']) ?>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        <?= formatDate($order['created_at']) ?>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                        <?= formatPrice($order['total']) ?>
                                    </td>
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
                                            'pending' => 'Pending',
                                            'processing' => 'Processing',
                                            'shipped' => 'Shipped',
                                            'delivered' => 'Delivered',
                                            'cancelled' => 'Cancelled',
                                        ];
                                        $color = $statusColors[$order['order_status']] ?? 'bg-gray-100 text-gray-800';
                                        $label = $statusLabels[$order['order_status']] ?? $order['order_status'];
                                        ?>
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium <?= $color ?>">
                                            <?= $label ?>
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <?php
                                        $paymentColors = [
                                            'paid' => 'bg-green-100 text-green-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'failed' => 'bg-red-100 text-red-800',
                                            'refunded' => 'bg-gray-100 text-gray-800',
                                        ];
                                        $paymentLabels = [
                                            'paid' => 'Paid',
                                            'pending' => 'Pending',
                                            'failed' => 'Failed',
                                            'refunded' => 'Refunded',
                                        ];
                                        $pColor = $paymentColors[$order['payment_status']] ?? 'bg-gray-100 text-gray-800';
                                        $pLabel = $paymentLabels[$order['payment_status']] ?? $order['payment_status'];
                                        ?>
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium <?= $pColor ?>">
                                            <?= $pLabel ?>
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                        <a href="<?= url('account/orders/' . $order['id']) ?>"
                                           class="font-medium text-indigo-600 hover:text-indigo-900">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="border-t border-gray-200 px-6 py-4">
                        <a href="<?= url('account/orders') ?>"
                           class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                            View all my orders &rarr;
                        </a>
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
                <p class="mt-1 text-xs text-gray-400">
                    Member since <?= formatDate($user['created_at']) ?>
                </p>
            </div>
            <a href="<?= url('account/profile') ?>"
               class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
                Edit
            </a>
        </div>
    </div>
</div>
<?php endSection() ?>
