<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
  <div class="max-w-4xl mx-auto px-4 py-8 sm:py-12">

    <!-- Header -->
    <div class="text-center mb-10">
      <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-5 shadow-inner">
        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
      </div>
      <h1 class="text-3xl sm:text-4xl font-black text-gray-900 mb-2">Order Confirmed! 🎉</h1>
      <p class="text-gray-500 text-sm sm:text-base">Thank you for your order. You'll receive a confirmation email shortly.</p>
      <div class="mt-4 inline-flex items-center gap-2 bg-gray-100 rounded-full px-5 py-2.5">
        <span class="text-sm text-gray-500">Order Number</span>
        <span class="text-sm font-bold text-gray-900 tracking-wide">#<?= e($order['order_number'] ?? '') ?></span>
      </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6">
      <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h2 class="text-base font-bold text-gray-900">Order Items</h2>
      </div>
      <div class="divide-y divide-gray-100">
        <?php $items = $order['items'] ?? []; ?>
        <?php foreach ($items as $item): ?>
        <div class="px-6 py-4 flex items-start gap-4">
          <div class="w-16 h-16 rounded-xl bg-gray-100 flex-shrink-0 overflow-hidden border border-gray-200">
            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-medium"><?= e(mb_substr($item['product_name'] ?? '', 0, 2)) ?></div>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-gray-900 truncate"><?= e($item['product_name'] ?? '') ?></p>
            <p class="text-xs text-gray-400 mt-0.5">Qty: <?= (int)($item['quantity'] ?? 0) ?> × <?= number_format((float)($item['unit_price'] ?? 0), 2) ?> <?= APP_CURRENCY ?></p>
          </div>
          <span class="text-sm font-bold text-gray-900 whitespace-nowrap"><?= number_format((float)($item['total_price'] ?? 0), 2) ?> <?= APP_CURRENCY ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Totals -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6">
      <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h2 class="text-base font-bold text-gray-900">Order Summary</h2>
      </div>
      <div class="px-6 py-4 space-y-3 text-sm">
        <div class="flex justify-between">
          <span class="text-gray-500">Subtotal</span>
          <span class="font-medium text-gray-900"><?= number_format((float)($order['subtotal'] ?? 0), 2) ?> <?= APP_CURRENCY ?></span>
        </div>
        <?php if (($order['discount'] ?? 0) > 0): ?>
        <div class="flex justify-between text-green-600">
          <span>Discount</span>
          <span>−<?= number_format((float)$order['discount'], 2) ?> <?= APP_CURRENCY ?></span>
        </div>
        <?php endif; ?>
        <div class="flex justify-between">
          <span class="text-gray-500">Shipping</span>
          <span class="font-medium text-gray-900">
            <?= (float)($order['shipping_cost'] ?? 0) == 0 ? '<span class="text-green-600 font-semibold">Free</span>' : number_format((float)$order['shipping_cost'], 2) . ' ' . APP_CURRENCY ?>
          </span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">TVA (20%)</span>
          <span class="font-medium text-gray-900"><?= number_format((float)($order['tax'] ?? 0), 2) ?> <?= APP_CURRENCY ?></span>
        </div>
        <div class="flex justify-between border-t border-gray-200 pt-3 text-base">
          <span class="font-bold text-gray-900">Total</span>
          <span class="font-black text-xl text-red-600"><?= number_format((float)($order['total'] ?? 0), 2) ?> <?= APP_CURRENCY ?></span>
        </div>
      </div>
    </div>

    <!-- Shipping & Payment -->
    <div class="grid sm:grid-cols-2 gap-6 mb-8">
      <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-2">
          <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          <h2 class="text-sm font-bold text-gray-900">Shipping Address</h2>
        </div>
        <div class="px-6 py-4 text-sm text-gray-600 space-y-1">
          <p class="font-semibold text-gray-900"><?= e($order['shipping_name'] ?? '') ?></p>
          <p><?= e($order['shipping_address'] ?? '') ?></p>
          <p><?= e($order['shipping_city'] ?? '') ?><?= $order['shipping_postal'] ? ', ' . e($order['shipping_postal']) : '' ?></p>
          <p><?= e($order['shipping_state'] ?? '') ?><?= $order['shipping_country'] ? ', ' . e($order['shipping_country']) : '' ?></p>
        </div>
      </div>
      <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-2">
          <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
          <h2 class="text-sm font-bold text-gray-900">Payment</h2>
        </div>
        <div class="px-6 py-4 text-sm text-gray-600 space-y-3">
          <div>
            <span class="text-gray-400 text-xs uppercase tracking-wide font-medium">Method</span>
            <p class="font-semibold text-gray-900 mt-0.5"><?= e($order['payment_method_name'] ?? 'Not specified') ?></p>
          </div>
          <div>
            <span class="text-gray-400 text-xs uppercase tracking-wide font-medium">Status</span>
            <p class="mt-0.5">
              <?php $ps = $order['payment_status'] ?? ''; ?>
              <?php if (in_array($ps, ['completed', 'paid'])): ?>
              <span class="inline-flex items-center gap-1 text-green-700 bg-green-50 px-2.5 py-1 rounded-full text-xs font-bold">Paid</span>
              <?php elseif ($ps === 'pending'): ?>
              <span class="inline-flex items-center gap-1 text-yellow-700 bg-yellow-50 px-2.5 py-1 rounded-full text-xs font-bold">Pending</span>
              <?php else: ?>
              <span class="inline-flex items-center gap-1 text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full text-xs font-bold"><?= e($ps ?: 'N/A') ?></span>
              <?php endif; ?>
            </p>
          </div>
          <?php if (!empty($order['shipping_method_name'])): ?>
          <div>
            <span class="text-gray-400 text-xs uppercase tracking-wide font-medium">Shipping Method</span>
            <p class="font-semibold text-gray-900 mt-0.5"><?= e($order['shipping_method_name']) ?></p>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
      <a href="<?= url('account/orders/' . (int)($order['id'] ?? 0)) ?>" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gray-900 text-white px-6 py-3 rounded-xl font-semibold text-sm hover:bg-gray-800 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        View My Orders
      </a>
      <a href="<?= url('products') ?>" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border-2 border-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold text-sm hover:bg-gray-50 hover:border-gray-300 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        Continue Shopping
      </a>
      <?php $orderRef = $order['order_number'] ?? ''; ?>
      <?php if ($orderRef): ?>
      <a href="https://wa.me/?text=<?= urlencode("I just ordered #{$orderRef} from " . url('') . "! 🎉") ?>" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-green-500 text-white px-6 py-3 rounded-xl font-semibold text-sm hover:bg-green-600 transition shadow-sm">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        Share on WhatsApp
      </a>
      <?php endif; ?>
    </div>

    <!-- Order info banner -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-2xl px-6 py-5 text-center">
      <p class="text-sm text-blue-800 font-medium">
        A confirmation email has been sent to <span class="font-bold"><?= e($order['email'] ?? 'your email') ?></span>
      </p>
      <p class="text-xs text-blue-600 mt-1">If you have any questions, please <a href="<?= url('contact') ?>" class="underline font-semibold hover:text-blue-800">contact us</a>.</p>
    </div>

  </div>
</div>
