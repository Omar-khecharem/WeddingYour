<table cellpadding="0" cellspacing="0" width="100%" style="background:#f4f4f5;font-family:Arial,Helvetica,sans-serif;padding:20px 0">
<tr><td align="center">
<table cellpadding="0" cellspacing="0" width="600" style="background:#ffffff;border-radius:8px;overflow:hidden">
<tr><td style="background:#1a1a2e;padding:30px 40px;text-align:center">
<h1 style="color:#ffffff;margin:0;font-size:24px">WeddingYour</h1>
<p style="color:#a0a0b8;margin:5px 0 0;font-size:13px">Order Confirmation</p>
</td></tr>
<tr><td style="padding:30px 40px">
<p style="margin:0 0 20px;font-size:15px;color:#333">Thank you for your order! Here is a summary of your purchase.</p>
<table cellpadding="0" cellspacing="0" width="100%">
<tr><td style="padding:8px 0;border-bottom:1px solid #eee;font-size:14px;color:#555"><strong>Order No.:</strong></td><td style="padding:8px 0;border-bottom:1px solid #eee;font-size:14px;color:#333"><?= $order['order_number'] ?></td></tr>
<tr><td style="padding:8px 0;border-bottom:1px solid #eee;font-size:14px;color:#555"><strong>Date:</strong></td><td style="padding:8px 0;border-bottom:1px solid #eee;font-size:14px;color:#333"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td></tr>
</table>
<table cellpadding="0" cellspacing="0" width="100%" style="margin:25px 0 0">
<tr><td style="background:#f8f8f8;padding:10px 12px;font-size:13px;font-weight:bold;color:#555;text-transform:uppercase;border-bottom:2px solid #ddd">Item</td>
<td style="background:#f8f8f8;padding:10px 12px;font-size:13px;font-weight:bold;color:#555;text-transform:uppercase;border-bottom:2px solid #ddd;text-align:center">Qty</td>
<td style="background:#f8f8f8;padding:10px 12px;font-size:13px;font-weight:bold;color:#555;text-transform:uppercase;border-bottom:2px solid #ddd;text-align:right">Price</td></tr>
<?php foreach ($order['items'] as $item): ?>
<tr><td style="padding:12px;border-bottom:1px solid #eee;font-size:14px;color:#333;vertical-align:middle">
<table cellpadding="0" cellspacing="0"><tr>
<td style="padding-right:12px"><?php if (!empty($item['image'])): ?><img src="<?= $item['image'] ?>" alt="" width="50" height="50" style="border-radius:4px;display:block"><?php endif; ?></td>
<td style="vertical-align:middle;font-size:14px;color:#333"><?= $item['name'] ?></td>
</tr></table>
</td>
<td style="padding:12px;border-bottom:1px solid #eee;text-align:center;font-size:14px;color:#333"><?= $item['qty'] ?></td>
<td style="padding:12px;border-bottom:1px solid #eee;text-align:right;font-size:14px;color:#333"><?= number_format($item['price'], 2) ?>&nbsp;&euro;</td></tr>
<?php endforeach; ?>
</table>
<table cellpadding="0" cellspacing="0" width="100%" style="margin:15px 0 0">
<tr><td style="padding:6px 12px;font-size:14px;color:#555;text-align:right">Subtotal</td><td style="padding:6px 12px;font-size:14px;color:#333;text-align:right;width:120px"><?= number_format($order['subtotal'], 2) ?>&nbsp;&euro;</td></tr>
<?php if (!empty($order['discount']) && $order['discount'] > 0): ?>
<tr><td style="padding:6px 12px;font-size:14px;color:#e74c3c;text-align:right">Discount</td><td style="padding:6px 12px;font-size:14px;color:#e74c3c;text-align:right">&ndash; <?= number_format($order['discount'], 2) ?>&nbsp;&euro;</td></tr>
<?php endif; ?>
<tr><td style="padding:6px 12px;font-size:14px;color:#555;text-align:right">Shipping (<?= $order['shipping_method_name'] ?>)</td><td style="padding:6px 12px;font-size:14px;color:#333;text-align:right"><?= number_format($order['shipping_cost'], 2) ?>&nbsp;&euro;</td></tr>
<tr><td style="padding:6px 12px;font-size:14px;color:#555;text-align:right">Tax</td><td style="padding:6px 12px;font-size:14px;color:#333;text-align:right"><?= number_format($order['tax'], 2) ?>&nbsp;&euro;</td></tr>
<tr><td style="padding:10px 12px;font-size:16px;font-weight:bold;color:#1a1a2e;text-align:right;border-top:2px solid #1a1a2e">Total</td><td style="padding:10px 12px;font-size:16px;font-weight:bold;color:#1a1a2e;text-align:right;border-top:2px solid #1a1a2e"><?= number_format($order['total'], 2) ?>&nbsp;&euro;</td></tr>
</table>
<table cellpadding="0" cellspacing="0" width="100%" style="margin:25px 0 0;background:#f9f9f9;border-radius:6px;padding:15px">
<tr><td style="font-size:14px;font-weight:bold;color:#333;padding-bottom:6px">Shipping Address</td></tr>
<tr><td style="font-size:14px;color:#555"><?= $order['billing_name'] ?></td></tr>
<tr><td style="font-size:14px;color:#555"><?= $order['billing_address'] ?></td></tr>
<tr><td style="font-size:14px;color:#555"><?= $order['billing_city'] ?></td></tr>
</table>
<p style="margin:25px 0 0;font-size:14px;color:#555">Payment: <strong><?= $order['payment_method_name'] ?></strong></p>
</td></tr>
<tr><td style="background:#f4f4f5;padding:20px 40px;text-align:center;font-size:12px;color:#888;border-top:1px solid #ddd">
<p style="margin:0 0 5px">WeddingYour &ndash; Your Online Store</p>
<p style="margin:0 0 5px">contact@weddingyour.com</p>
<p style="margin:0"><a href="{{unsubscribe_url}}" style="color:#888;text-decoration:underline">Unsubscribe</a></p>
</td></tr>
</table>
</td></tr>
</table>
