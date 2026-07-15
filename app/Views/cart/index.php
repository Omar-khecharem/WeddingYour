<?php if (empty($cart['items'])): ?>
<div class="max-w-2xl mx-auto text-center py-16">
    <div class="text-gray-400 mb-6">
        <svg class="mx-auto h-24 w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
        </svg>
    </div>
    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Votre panier est vide</h2>
    <p class="text-gray-500 mb-8">Découvrez notre collection et ajoutez des articles à votre panier.</p>
    <a href="<?= url('products') ?>" class="inline-block bg-gray-900 text-white px-8 py-3 rounded-lg hover:bg-gray-800 transition">
        Découvrir nos produits
    </a>
</div>
<?php else: ?>
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Mon Panier</h1>

    <div class="lg:grid lg:grid-cols-3 lg:gap-10">
        <div class="lg:col-span-2">
            <div class="overflow-hidden border border-gray-200 rounded-lg">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left py-4 px-4 font-medium text-gray-600">Produit</th>
                            <th class="text-center py-4 px-4 font-medium text-gray-600">Prix unitaire</th>
                            <th class="text-center py-4 px-4 font-medium text-gray-600">Quantité</th>
                            <th class="text-right py-4 px-4 font-medium text-gray-600">Total</th>
                            <th class="py-4 px-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($cart['items'] as $item): ?>
                        <tr class="cart-item" data-item-id="<?= $item['id'] ?>">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-4">
                                    <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="w-20 h-20 object-cover rounded-lg">
                                    <div>
                                        <a href="<?= url('product/' . $item['slug']) ?>" class="font-medium text-gray-900 hover:text-gray-600 transition">
                                            <?= $item['name'] ?>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="unit-price font-medium text-gray-900"><?= number_format($item['unit_price'], 2) ?> €</span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-1">
                                    <button type="button" class="qty-btn qty-down w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100 transition" data-item-id="<?= $item['id'] ?>">−</button>
                                    <input type="number" value="<?= $item['quantity'] ?>" min="1" class="qty-input w-14 h-8 text-center border border-gray-300 rounded-lg text-sm" data-item-id="<?= $item['id'] ?>" data-price="<?= $item['unit_price'] ?>">
                                    <button type="button" class="qty-btn qty-up w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100 transition" data-item-id="<?= $item['id'] ?>">+</button>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <span class="line-total font-semibold text-gray-900"><?= number_format($item['line_total'] ?? ($item['unit_price'] * $item['quantity']), 2) ?> €</span>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <button type="button" class="remove-btn text-gray-400 hover:text-red-500 transition" data-item-id="<?= $item['id'] ?>">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <a href="<?= url('products') ?>" class="text-sm text-gray-600 hover:text-gray-900 transition inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Continuer mes achats
                </a>
            </div>
        </div>

        <div class="mt-8 lg:mt-0">
            <div class="border border-gray-200 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Résumé du panier</h2>

                <!-- Coupon -->
                <div class="mb-6">
                    <?php if (!empty($cart['coupon_code'])): ?>
                    <div class="flex items-center justify-between bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                        <div>
                            <span class="text-sm font-medium text-green-800">Code : <?= $cart['coupon_code'] ?></span>
                            <span class="block text-xs text-green-600">−<?= number_format($cart['coupon_discount'] ?? 0, 2) ?> € de réduction</span>
                        </div>
                        <button type="button" id="remove-coupon" class="text-green-600 hover:text-green-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <?php else: ?>
                    <div class="flex gap-2">
                        <input type="text" id="coupon-input" placeholder="Code promo" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none">
                        <button type="button" id="apply-coupon" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800 transition">Appliquer</button>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sous-total</span>
                        <span class="font-medium text-gray-900"><?= number_format($cart['subtotal'], 2) ?> €</span>
                    </div>

                    <?php if (($cart['discount'] ?? 0) > 0): ?>
                    <div class="flex justify-between text-green-600">
                        <span>Réduction</span>
                        <span class="font-medium">−<?= number_format($cart['discount'], 2) ?> €</span>
                    </div>
                    <?php endif; ?>

                    <div class="flex justify-between">
                        <span class="text-gray-600">TVA</span>
                        <span class="font-medium text-gray-900"><?= number_format($cart['tax'], 2) ?> €</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Livraison</span>
                        <?php if ($cart['shipping'] == 0): ?>
                        <span class="font-medium text-green-600">Gratuite</span>
                        <?php else: ?>
                        <span class="font-medium text-gray-900"><?= number_format($cart['shipping'], 2) ?> €</span>
                        <?php endif; ?>
                    </div>

                    <?php if (($cart['free_shipping_min'] ?? 0) > 0 && $cart['shipping'] == 0): ?>
                    <p class="text-xs text-green-600">Livraison offerte à partir de <?= number_format($cart['free_shipping_min'], 2) ?> € d'achat</p>
                    <?php endif; ?>

                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between text-base">
                            <span class="font-semibold text-gray-900">Total</span>
                            <span class="font-bold text-xl text-gray-900"><?= number_format($cart['total'], 2) ?> €</span>
                        </div>
                    </div>
                </div>

                <a href="<?= url('checkout') ?>" class="mt-6 block w-full text-center bg-gray-900 text-white py-3 rounded-lg font-medium hover:bg-gray-800 transition">
                    Commander
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    <?php if (!empty($cart['items'])): ?>
    async function updateCart(itemId, quantity) {
        try {
            const res = await fetch('<?= url('cart/update') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': window.CSRF_TOKEN },
                body: JSON.stringify({ item_id: itemId, quantity: quantity })
            });
            if (res.ok) location.reload();
        } catch (e) { console.error(e); }
    }

    async function removeItem(itemId) {
        try {
            const res = await fetch('<?= url('cart/remove') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': window.CSRF_TOKEN },
                body: JSON.stringify({ item_id: itemId })
            });
            if (res.ok) location.reload();
        } catch (e) { console.error(e); }
    }
    document.querySelectorAll('.qty-down').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.itemId;
            const input = document.querySelector(`.qty-input[data-item-id="${id}"]`);
            let qty = parseInt(input.value);
            if (qty > 1) updateCart(id, qty - 1);
        });
    });

    document.querySelectorAll('.qty-up').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.itemId;
            const input = document.querySelector(`.qty-input[data-item-id="${id}"]`);
            let qty = parseInt(input.value);
            updateCart(id, qty + 1);
        });
    });

    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', function () {
            const id = this.dataset.itemId;
            let qty = parseInt(this.value);
            if (qty < 1) qty = 1;
            updateCart(id, qty);
        });
    });

    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            if (confirm('Êtes-vous sûr de vouloir retirer cet article ?')) {
                removeItem(this.dataset.itemId);
            }
        });
    });

    <?php if (empty($cart['coupon_code'])): ?>
    document.getElementById('apply-coupon').addEventListener('click', async function () {
        const code = document.getElementById('coupon-input').value.trim();
        if (!code) return;
        try {
            const res = await fetch('<?= url('cart/coupon') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': window.CSRF_TOKEN },
                body: JSON.stringify({ code: code })
            });
            if (res.ok) location.reload();
        } catch (e) { console.error(e); }
    });
    <?php else: ?>
    document.getElementById('remove-coupon').addEventListener('click', async function () {
        try {
            const res = await fetch('<?= url('cart/coupon') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': window.CSRF_TOKEN },
                body: JSON.stringify({ code: '' })
            });
            if (res.ok) location.reload();
        } catch (e) { console.error(e); }
    });
    <?php endif; ?>

    <?php endif; ?>
});
</script>
