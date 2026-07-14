🛒 *Nouvelle commande #<?= e($order['order_number']) ?>*
📅 <?= date('d/m/Y H:i', strtotime($order['created_at'] ?? 'now')) ?>

📦 *Articles commandés :*
<?php foreach ($order['items'] as $item): ?>
  • <?= e($item['name']) ?> x<?= (int) $item['quantity'] ?> = <?= number_format($item['quantity'] * $item['price'], 2) ?> €
<?php endforeach; ?>

💰 *Total :* <?= number_format($order['total'] ?? 0, 2) ?> €

📍 *Adresse de livraison :*
  <?= e($order['delivery_address']['name']) ?>
  <?= e($order['delivery_address']['street']) ?>
  <?= e($order['delivery_address']['postcode'] ?? '') ?> <?= e($order['delivery_address']['city'] ?? '') ?>

💳 *Paiement :* <?= e($order['payment_method'] ?? 'Non spécifié') ?>
<?php if (!empty($order['notes'])): ?>

📝 *Notes :* <?= e($order['notes']) ?>
<?php endif; ?>
