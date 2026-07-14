<div class="max-w-3xl mx-auto px-4 py-12 text-center">
    <!-- Success icon -->
    <div class="mb-6">
        <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
    </div>

    <h1 class="text-3xl font-bold text-gray-900 mb-2">Commande confirmée !</h1>
    <p class="text-gray-500 mb-2">Merci pour votre commande.</p>
    <p class="text-lg font-semibold text-gray-900 mb-8">
        Numéro de commande : <span class="text-gray-900">#<?= $order['id'] ?? $order['order_number'] ?? '' ?></span>
    </p>

    <!-- Order details -->
    <div class="text-left border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Détails de la commande</h2>

        <div class="space-y-4 mb-6">
            <?php foreach ($order['items'] as $item): ?>
            <div class="flex items-start gap-3">
                <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900"><?= $item['name'] ?></p>
                    <p class="text-xs text-gray-500">Qté : <?= $item['quantity'] ?> × <?= number_format($item['unit_price'], 2) ?> €</p>
                </div>
                <span class="text-sm font-semibold text-gray-900"><?= number_format($item['total_price'] ?? ($item['unit_price'] * $item['quantity']), 2) ?> €</span>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="border-t border-gray-200 pt-4 space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-600">Sous-total</span>
                <span class="font-medium text-gray-900"><?= number_format($order['subtotal'], 2) ?> €</span>
            </div>
            <?php if (($order['discount'] ?? 0) > 0): ?>
            <div class="flex justify-between text-green-600">
                <span>Réduction</span>
                <span>−<?= number_format($order['discount'], 2) ?> €</span>
            </div>
            <?php endif; ?>
            <div class="flex justify-between">
                <span class="text-gray-600">Livraison</span>
                <span class="font-medium text-gray-900">
                    <?php if (($order['shipping'] ?? 0) == 0): ?>
                    <span class="text-green-600">Gratuite</span>
                    <?php else: ?>
                    <?= number_format($order['shipping'], 2) ?> €
                    <?php endif; ?>
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">TVA</span>
                <span class="font-medium text-gray-900"><?= number_format($order['tax'], 2) ?> €</span>
            </div>
            <div class="flex justify-between border-t border-gray-200 pt-2 text-base">
                <span class="font-semibold text-gray-900">Total</span>
                <span class="font-bold text-xl text-gray-900"><?= number_format($order['total'], 2) ?> €</span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Adresse de livraison</h3>
                <p class="text-gray-600"><?= $order['shipping_address']['full_name'] ?? $order['shipping_full_name'] ?? '' ?></p>
                <p class="text-gray-600"><?= $order['shipping_address']['address_line1'] ?? $order['shipping_address_line1'] ?? '' ?></p>
                <?php if (!empty($order['shipping_address']['address_line2']) || !empty($order['shipping_address_line2'])): ?>
                <p class="text-gray-600"><?= $order['shipping_address']['address_line2'] ?? $order['shipping_address_line2'] ?? '' ?></p>
                <?php endif; ?>
                <p class="text-gray-600"><?= $order['shipping_address']['postal_code'] ?? $order['shipping_postal_code'] ?? '' ?> <?= $order['shipping_address']['city'] ?? $order['shipping_city'] ?? '' ?></p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Mode de paiement</h3>
                <p class="text-gray-600"><?= $order['payment_method_name'] ?? $order['payment_method'] ?? '' ?></p>
                <h3 class="font-semibold text-gray-900 mt-3 mb-1">Mode de livraison</h3>
                <p class="text-gray-600"><?= $order['shipping_method_name'] ?? $order['shipping_method'] ?? '' ?></p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="<?= url('account/orders/' . ($order['id'] ?? 0) . '/invoice') ?>" class="inline-flex items-center gap-2 bg-gray-900 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Télécharger la facture
        </a>

        <?php $orderRef = $order['order_number'] ?? $order['id'] ?? ''; ?>
        <a href="https://wa.me/?text=<?= urlencode("Je viens de commander #{$orderRef} sur " . url('') . " ! 🎉") ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-green-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-600 transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            Partager sur WhatsApp
        </a>

        <a href="<?= url('products') ?>" class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 transition">
            Continuer mes achats
        </a>
    </div>
</div>
