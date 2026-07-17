<table cellpadding="0" cellspacing="0" width="100%" style="background:#f4f4f5;font-family:Arial,Helvetica,sans-serif;padding:20px 0">
<tr><td align="center">
<table cellpadding="0" cellspacing="0" width="600" style="background:#ffffff;border-radius:8px;overflow:hidden">
<tr><td style="background:#1a1a2e;padding:30px 40px;text-align:center">
<h1 style="color:#ffffff;margin:0;font-size:24px">Shola Ghar</h1>
<p style="color:#a0a0b8;margin:5px 0 0;font-size:13px">New Contact Message</p>
</td></tr>
<tr><td style="padding:30px 40px">
<p style="margin:0 0 20px;font-size:15px;color:#333">A new message has been sent from the contact form.</p>
<table cellpadding="0" cellspacing="0" width="100%" style="margin:15px 0">
<tr><td style="padding:10px 0;border-bottom:1px solid #eee;font-size:14px;color:#555"><strong>Nom&nbsp;:</strong></td><td style="padding:10px 0;border-bottom:1px solid #eee;font-size:14px;color:#333"><?= $data['name'] ?></td></tr>
<tr><td style="padding:10px 0;border-bottom:1px solid #eee;font-size:14px;color:#555"><strong>E-mail&nbsp;:</strong></td><td style="padding:10px 0;border-bottom:1px solid #eee;font-size:14px;color:#333"><a href="mailto:<?= $data['email'] ?>" style="color:#1a1a2e"><?= $data['email'] ?></a></td></tr>
<tr><td style="padding:10px 0;border-bottom:1px solid #eee;font-size:14px;color:#555"><strong>Subject:</strong></td><td style="padding:10px 0;border-bottom:1px solid #eee;font-size:14px;color:#333"><?= $data['subject'] ?></td></tr>
<tr><td style="padding:10px 0;border-bottom:1px solid #eee;font-size:14px;color:#555"><strong>Date&nbsp;:</strong></td><td style="padding:10px 0;border-bottom:1px solid #eee;font-size:14px;color:#333"><?= date('d/m/Y H:i') ?></td></tr>
</table>
<table cellpadding="0" cellspacing="0" width="100%" style="margin:15px 0;background:#f9f9f9;border-radius:6px;padding:20px">
<tr><td style="font-size:14px;font-weight:bold;color:#333;padding-bottom:8px">Message</td></tr>
<tr><td style="font-size:14px;color:#555;line-height:1.6"><?= nl2br($data['message']) ?></td></tr>
</table>
</td></tr>
<tr><td style="background:#f4f4f5;padding:20px 40px;text-align:center;font-size:12px;color:#888;border-top:1px solid #ddd">
<p style="margin:0 0 5px">Shola Ghar &ndash; Your Online Store</p>
<p style="margin:0 0 5px">contact@sholaghar.com</p>
<p style="margin:0"><a href="{{unsubscribe_url}}" style="color:#888;text-decoration:underline">Unsubscribe</a></p>
</td></tr>
</table>
</td></tr>
</table>
