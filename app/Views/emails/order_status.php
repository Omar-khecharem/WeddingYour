<table cellpadding="0" cellspacing="0" width="100%" style="background:#f4f4f5;font-family:Arial,Helvetica,sans-serif;padding:20px 0">
<tr><td align="center">
<table cellpadding="0" cellspacing="0" width="600" style="background:#ffffff;border-radius:8px;overflow:hidden">
<tr><td style="background:#1a1a2e;padding:30px 40px;text-align:center">
<h1 style="color:#ffffff;margin:0;font-size:24px">Shola Ghar</h1>
<p style="color:#a0a0b8;margin:5px 0 0;font-size:13px">Mise &agrave; jour de commande</p>
</td></tr>
<tr><td style="padding:30px 40px">
<p style="margin:0 0 20px;font-size:15px;color:#333">Bonjour,</p>
<p style="margin:0 0 20px;font-size:15px;color:#333">Le statut de votre commande <strong>#<?= $order['order_number'] ?></strong> a &eacute;t&eacute; mis &agrave; jour.</p>
<table cellpadding="0" cellspacing="0" width="100%" style="margin:20px 0">
<tr><td style="padding:12px;background:#f9f9f9;border-radius:6px;text-align:center;font-size:14px;color:#555">
Statut pr&eacute;c&eacute;dent&nbsp;: <strong style="color:#999"><?= $statusLabels[$oldStatus] ?? $oldStatus ?></strong>
</td></tr>
<tr><td style="padding:10px;text-align:center;font-size:20px;color:#aaa">&darr;</td></tr>
<tr><td style="padding:12px;background:#eaf6ef;border-radius:6px;text-align:center;font-size:14px;font-weight:bold;color:#27ae60;border:1px solid #c3e6d1">
Nouveau statut&nbsp;: <?= $statusLabels[$newStatus] ?? $newStatus ?>
</td></tr>
</table>
<?php if (!empty($order['tracking_number'])): ?>
<table cellpadding="0" cellspacing="0" width="100%" style="margin:15px 0;background:#f0f7ff;border-radius:6px;padding:15px;border:1px solid #cce5ff">
<tr><td style="font-size:14px;color:#333;text-align:center">
Num&eacute;ro de suivi&nbsp;: <strong><?= $order['tracking_number'] ?></strong>
</td></tr>
<tr><td style="padding:12px 0 0;text-align:center">
<a href="<?= $order['tracking_url'] ?? '#' ?>" style="display:inline-block;padding:10px 24px;background:#1a1a2e;color:#ffffff;text-decoration:none;border-radius:4px;font-size:14px">Suivre ma commande</a>
</td></tr>
</table>
<?php endif; ?>
<table cellpadding="0" cellspacing="0" width="100%" style="margin:20px 0 0">
<tr><td style="padding:8px 0;border-bottom:1px solid #eee;font-size:14px;color:#555"><strong>Commande n&deg;&nbsp;:</strong></td><td style="padding:8px 0;border-bottom:1px solid #eee;font-size:14px;color:#333"><?= $order['order_number'] ?></td></tr>
<tr><td style="padding:8px 0;font-size:14px;color:#555"><strong>Date&nbsp;:</strong></td><td style="padding:8px 0;font-size:14px;color:#333"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td></tr>
</table>
<p style="margin:20px 0 0;font-size:14px;color:#555">Si vous avez des questions, n&rsquo;h&eacute;sitez pas &agrave; nous contacter.</p>
</td></tr>
<tr><td style="background:#f4f4f5;padding:20px 40px;text-align:center;font-size:12px;color:#888;border-top:1px solid #ddd">
<p style="margin:0 0 5px">Shola Ghar &ndash; Votre boutique en ligne</p>
<p style="margin:0 0 5px">contact@sholaghar.com</p>
<p style="margin:0"><a href="{{unsubscribe_url}}" style="color:#888;text-decoration:underline">Se d&eacute;sabonner</a></p>
</td></tr>
</table>
</td></tr>
</table>
