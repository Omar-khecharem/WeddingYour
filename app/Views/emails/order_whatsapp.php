🛒 *New Order #<?= e($order['order_number']) ?>*
📅 <?= date('d/m/Y H:i', strtotime($order['created_at'] ?? 'now')) ?>

📦 *Ordered Items:*
<?php foreach ($order['items'] as $item): ?>
  • <?= e($item['name']) ?> x<?= (int) $item['quantity'] ?> = <?= number_format($item['quantity'] * $item['price'], 2) ?>  <?= APP_CURRENCY ?>
<?php endforeach; ?>

💰 *Total:* <?= number_format($order['total'] ?? 0, 2) ?>  <?= APP_CURRENCY ?>

📍 *Shipping Address:*
  <?= e($order['delivery_address']['name']) ?>
  <?= e($order['delivery_address']['street']) ?>
  <?= e($order['delivery_address']['postcode'] ?? '') ?> <?= e($order['delivery_address']['city'] ?? '') ?>

💳 *Payment:* <?= e($order['payment_method_name'] ?? $order['payment_method'] ?? 'Not specified') ?>
<?php if (!empty($order['notes'])): ?>

📝 *Notes:* <?= e($order['notes']) ?>
<?php endif; ?>
