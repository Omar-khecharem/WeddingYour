<table cellpadding="0" cellspacing="0" width="100%" style="background:#f4f4f5;font-family:Arial,Helvetica,sans-serif;padding:20px 0">
<tr><td align="center">
<table cellpadding="0" cellspacing="0" width="600" style="background:#ffffff;border-radius:8px;overflow:hidden">
<tr><td style="background:#1a1a2e;padding:30px 40px;text-align:center">
<h1 style="color:#ffffff;margin:0;font-size:24px">WeddingYour</h1>
<p style="color:#a0a0b8;margin:5px 0 0;font-size:13px">Order Update</p>
</td></tr>
<tr><td style="padding:30px 40px">
<p style="margin:0 0 20px;font-size:15px;color:#333">Bonjour,</p>
<p style="margin:0 0 20px;font-size:15px;color:#333">Your order <strong>#<?= $order['order_number'] ?></strong> status has been updated.</p>
<table cellpadding="0" cellspacing="0" width="100%" style="margin:20px 0">
<tr><td style="padding:12px;background:#f9f9f9;border-radius:6px;text-align:center;font-size:14px;color:#555">
Previous Status: <strong style="color:#999"><?= $statusLabels[$oldStatus] ?? $oldStatus ?></strong>
</td></tr>
<tr><td style="padding:10px;text-align:center;font-size:20px;color:#aaa">&darr;</td></tr>
<tr><td style="padding:12px;background:#eaf6ef;border-radius:6px;text-align:center;font-size:14px;font-weight:bold;color:#27ae60;border:1px solid #c3e6d1">
New Status: <?= $statusLabels[$newStatus] ?? $newStatus ?>
</td></tr>
</table>
<?php if (!empty($order['tracking_number'])): ?>
<table cellpadding="0" cellspacing="0" width="100%" style="margin:15px 0;background:#f0f7ff;border-radius:6px;padding:15px;border:1px solid #cce5ff">
<tr><td style="font-size:14px;color:#333;text-align:center">
Tracking Number: <strong><?= $order['tracking_number'] ?></strong>
</td></tr>
<tr><td style="padding:12px 0 0;text-align:center">
<a href="<?= $order['tracking_url'] ?? '#' ?>" style="display:inline-block;padding:10px 24px;background:#1a1a2e;color:#ffffff;text-decoration:none;border-radius:4px;font-size:14px">Track My Order</a>
</td></tr>
</table>
<?php endif; ?>
<table cellpadding="0" cellspacing="0" width="100%" style="margin:20px 0 0">
<tr><td style="padding:8px 0;border-bottom:1px solid #eee;font-size:14px;color:#555"><strong>Order No.:</strong></td><td style="padding:8px 0;border-bottom:1px solid #eee;font-size:14px;color:#333"><?= $order['order_number'] ?></td></tr>
<tr><td style="padding:8px 0;font-size:14px;color:#555"><strong>Date:</strong></td><td style="padding:8px 0;font-size:14px;color:#333"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td></tr>
</table>
<p style="margin:20px 0 0;font-size:14px;color:#555">If you have any questions, feel free to contact us.</p>
</td></tr>
<tr><td style="background:#f4f4f5;padding:20px 40px;text-align:center;font-size:12px;color:#888;border-top:1px solid #ddd">
<p style="margin:0 0 5px">WeddingYour &ndash; Your Online Store</p>
<p style="margin:0 0 5px">contact@weddingyour.com</p>
<p style="margin:0"><a href="{{unsubscribe_url}}" style="color:#888;text-decoration:underline">Unsubscribe</a></p>
</td></tr>
</table>
</td></tr>
</table>
