<?php
$stats = $stats ?? [];
$wishlistCount = \App\Helpers\Session::get('wishlist.count', 0);
?>
<?php startSection('content') ?>
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mt-8">
        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
            Hello, <?= e($user['name']) ?> !
        </h1>
        <p class="mt-2 text-sm text-gray-500">
            Welcome to your account. Manage your orders, addresses and personal information.
        </p>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-gray-200 bg-white p-4 lg:p-5 shadow-sm transition-shadow hover:shadow-md">
            <div class="flex items-center gap-3 lg:gap-4">
                <div class="flex h-10 w-10 lg:h-11 lg:w-11 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 flex-shrink-0">
                    <svg class="h-5 w-5 lg:h-5 lg:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Total Orders</p>
                    <p class="text-lg lg:text-xl xl:text-2xl font-bold text-gray-900"><?= (int)($stats['total_orders'] ?? 0) ?></p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 lg:p-5 shadow-sm transition-shadow hover:shadow-md">
            <div class="flex items-center gap-3 lg:gap-4">
                <div class="flex h-10 w-10 lg:h-11 lg:w-11 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 flex-shrink-0">
                    <svg class="h-5 w-5 lg:h-5 lg:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Total Spent</p>
                    <p class="text-lg lg:text-xl xl:text-2xl font-bold text-gray-900"><?= formatPrice((float)($stats['total_spent'] ?? 0)) ?></p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 lg:p-5 shadow-sm transition-shadow hover:shadow-md">
            <div class="flex items-center gap-3 lg:gap-4">
                <div class="flex h-10 w-10 lg:h-11 lg:w-11 items-center justify-center rounded-lg bg-rose-100 text-rose-600 flex-shrink-0">
                    <svg class="h-5 w-5 lg:h-5 lg:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Wishlist</p>
                    <p class="text-lg lg:text-xl xl:text-2xl font-bold text-gray-900"><?= (int)$wishlistCount ?></p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 lg:p-5 shadow-sm transition-shadow hover:shadow-md">
            <div class="flex items-center gap-3 lg:gap-4">
                <div class="flex h-10 w-10 lg:h-11 lg:w-11 items-center justify-center rounded-lg bg-amber-100 text-amber-600 flex-shrink-0">
                    <svg class="h-5 w-5 lg:h-5 lg:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Pending Orders</p>
                    <p class="text-lg lg:text-xl xl:text-2xl font-bold text-gray-900"><?= (int)($stats['pending_orders'] ?? 0) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-10">
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-4 sm:px-6 py-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>
                <?php if (!empty($recentOrders)): ?>
                <a href="<?= url('account/orders') ?>" class="text-sm font-medium text-primary-red hover:text-primary-red/80 transition-colors">View All</a>
                <?php endif; ?>
            </div>

            <?php if (empty($recentOrders)): ?>
                <div class="px-4 sm:px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="mt-4 text-sm text-gray-500">No orders yet.</p>
                    <a href="<?= url('products') ?>" class="mt-4 inline-block rounded-lg bg-primary-red px-5 py-2.5 text-sm font-semibold text-white hover:opacity-90 transition-all shadow-sm">
                        <i class="fa-solid fa-bag-shopping mr-1.5"></i> Browse Products
                    </a>
                </div>
            <?php else: ?>

            <!-- Desktop table: hidden on small screens -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50/80">
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Order #</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Date</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Total</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 hidden md:table-cell">Status</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 hidden lg:table-cell">Payment</th>
                            <th class="px-4 sm:px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($recentOrders as $order): ?>
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap font-semibold text-gray-900">#<?= e($order['order_number'] ?? '') ?></td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-gray-500"><?= formatDate($order['created_at'] ?? '') ?></td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap font-semibold text-gray-900"><?= formatPrice((float)($order['total'] ?? 0)) ?></td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                    <?php
                                    $sc = ['pending' => 'bg-yellow-100 text-yellow-700', 'processing' => 'bg-blue-100 text-blue-700', 'shipped' => 'bg-purple-100 text-purple-700', 'delivered' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700'];
                                    $sl = ['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];
                                    $s = $order['order_status'] ?? '';
                                    ?>
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold <?= $sc[$s] ?? 'bg-gray-100 text-gray-600' ?>"><?= $sl[$s] ?? $s ?></span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                    <?php
                                    $pc = ['paid' => 'bg-green-100 text-green-700', 'completed' => 'bg-green-100 text-green-700', 'pending' => 'bg-yellow-100 text-yellow-700', 'failed' => 'bg-red-100 text-red-700', 'refunded' => 'bg-gray-100 text-gray-600'];
                                    $pl = ['paid' => 'Paid', 'completed' => 'Paid', 'pending' => 'Pending', 'failed' => 'Failed', 'refunded' => 'Refunded'];
                                    $ps = $order['payment_status'] ?? '';
                                    ?>
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold <?= $pc[$ps] ?? 'bg-gray-100 text-gray-600' ?>"><?= $pl[$ps] ?? $ps ?></span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right">
                                    <a href="<?= url('account/orders/' . $order['id']) ?>" class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary-red hover:text-primary-red/80 transition-colors">
                                        View <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile cards: shown only on small screens -->
            <div class="sm:hidden divide-y divide-gray-100">
                <?php foreach ($recentOrders as $order): ?>
                    <a href="<?= url('account/orders/' . $order['id']) ?>" class="block px-4 py-4 hover:bg-gray-50/50 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-gray-900 text-sm">#<?= e($order['order_number'] ?? '') ?></span>
                            <?php
                            $sc = ['pending' => 'bg-yellow-100 text-yellow-700', 'processing' => 'bg-blue-100 text-blue-700', 'shipped' => 'bg-purple-100 text-purple-700', 'delivered' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700'];
                            $sl = ['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];
                            $s = $order['order_status'] ?? '';
                            ?>
                            <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-bold <?= $sc[$s] ?? 'bg-gray-100 text-gray-600' ?>"><?= $sl[$s] ?? $s ?></span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span><?= formatDate($order['created_at'] ?? '') ?></span>
                            <span class="font-semibold text-gray-900"><?= formatPrice((float)($order['total'] ?? 0)) ?></span>
                        </div>
                        <?php $ps = $order['payment_status'] ?? ''; ?>
                        <?php if (in_array($ps, ['paid', 'completed', 'pending', 'failed'])): ?>
                        <div class="mt-1.5 text-xs text-gray-400">
                            Payment: <span class="font-medium <?= in_array($ps, ['paid', 'completed']) ? 'text-green-600' : ($ps === 'failed' ? 'text-red-500' : 'text-yellow-600') ?>">
                                <?= $pl[$ps] ?? $ps ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        <div class="mt-2 flex items-center text-xs font-semibold text-primary-red">
                            View Details <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php endif; ?>
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
                <?php if ($memberSince): ?>                <p class="mt-1 text-xs text-gray-400">Member since <?= formatDate($memberSince) ?></p><?php endif; ?>
            </div>
            <a href="<?= url('account/profile') ?>" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">Edit</a>
        </div>
    </div>
</div>
<?php endSection() ?>
