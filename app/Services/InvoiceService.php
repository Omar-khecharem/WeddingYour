<?php
/**
 * Invoice Service
 * 
 * Generates professional PDF invoices for orders using TCPDF,
 * App\Helpers\Pdf fallback, or high-quality HTML output.
 */

namespace App\Services;

use App\Helpers\Format;
use App\Models\Setting;

class InvoiceService
{
    private const INVOICES_DIR = ROOT_DIR . '/invoices';

    public static function generate(array $order, bool $download = false): string
    {
        self::ensureDirectory();

        $html = self::renderHtml($order);
        $filename = self::filename($order);
        $filepath = self::INVOICES_DIR . '/' . $filename;

        // Try TCPDF
        if (class_exists('\TCPDF')) {
            return self::generateWithTcpdf($html, $filepath, $download);
        }

        // Try App\Helpers\Pdf
        if (class_exists('\App\Helpers\Pdf')) {
            return \App\Helpers\Pdf::generate($html, $filepath, $download);
        }

        // Save as HTML file
        file_put_contents($filepath, $html);

        if ($download) {
            header('Content-Type: text/html');
            header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            readfile($filepath);
            exit;
        }

        return $filepath;
    }

    public static function filename(array $order): string
    {
        $inv = $order['invoice_number'] ?? self::getNextInvoiceNumber();
        return 'invoice-' . $inv . '.html';
    }

    public static function renderHtml(array $order): string
    {
        $settings = self::getSettings();
        $currency = $settings['currency'] ?? '₹';
        $currencyCode = $settings['currency_code'] ?? 'INR';
        $companyName = $settings['company_name'] ?: (\App\Models\Setting::get('site_name', APP_NAME));
        $companyAddress = $settings['company_address'] ?? CONTACT_ADDRESS;
        $companyPhone = $settings['company_phone'] ?? CONTACT_PHONE;
        $companyEmail = $settings['company_email'] ?? CONTACT_EMAIL;
        $bankDetails = $settings['bank_details'] ?? ('Account: ' . $companyName . ' | Bank: HDFC Bank | A/C: 50200012345678 | IFSC: HDFC0001234');
        $terms = $settings['invoice_terms'] ?? 'Goods once sold cannot be returned or exchanged. Payment must be made within 7 days of invoice date.';
        $taxName = $settings['tax_name'] ?? TAX_NAME;
        $taxRate = $settings['tax_rate'] ?? TAX_RATE;
        $logo = $settings['logo_url'] ?: (\App\Models\Setting::get('site_logo', ''));

        $invoiceNumber = $order['invoice_number'] ?? self::getNextInvoiceNumber();
        $orderDate = !empty($order['created_at']) ? date('d M, Y', strtotime($order['created_at'])) : date('d M, Y');
        $dueDate = !empty($order['created_at']) ? date('d M, Y', strtotime($order['created_at'] . ' +7 days')) : date('d M, Y', strtotime('+7 days'));

        $paymentStatus = $order['payment_status'] ?? 'pending';
        $paymentMethod = $order['payment_method'] ?? '';
        $paymentBadge = match ($paymentStatus) {
            'completed', 'paid' => '<span style="background:#16a34a;color:#fff;padding:4px 12px;border-radius:4px;font-size:12px;font-weight:600;">PAID</span>',
            'failed' => '<span style="background:#dc2626;color:#fff;padding:4px 12px;border-radius:4px;font-size:12px;font-weight:600;">FAILED</span>',
            'refunded' => '<span style="background:#9333ea;color:#fff;padding:4px 12px;border-radius:4px;font-size:12px;font-weight:600;">REFUNDED</span>',
            default => '<span style="background:#f59e0b;color:#fff;padding:4px 12px;border-radius:4px;font-size:12px;font-weight:600;">PENDING</span>',
        };

        $paymentMethodLabel = match ($paymentMethod) {
            'cod' => 'Cash on Delivery',
            'razorpay' => 'Razorpay (Card/UPI/Net Banking)',
            'bank_transfer' => 'Bank Transfer',
            default => ucfirst(str_replace('_', ' ', $paymentMethod)),
        };

        $itemsHtml = '';
        $items = $order['items'] ?? [];
        $rowIndex = 0;

        foreach ($items as $item) {
            $rowIndex++;
            $bgColor = $rowIndex % 2 === 0 ? '#f8fafc' : '#ffffff';
            $productName = htmlspecialchars($item['product_name'] ?? $item['name'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
            $sku = htmlspecialchars($item['sku'] ?? '', ENT_QUOTES, 'UTF-8');
            $qty = (int)($item['quantity'] ?? 0);
            $unitPrice = (float)($item['unit_price'] ?? 0);
            $totalPrice = (float)($item['total_price'] ?? $item['total'] ?? ($qty * $unitPrice));
            $imageUrl = '';

            if (!empty($item['image'])) {
                $imageUrl = $item['image'];
            } elseif (!empty($item['product_id'])) {
                $imageUrl = self::getProductImageUrl((int)$item['product_id']);
            }

            $imgTag = $imageUrl
                ? '<img src="' . htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') . '" width="48" height="48" style="border-radius:6px;object-fit:cover;border:1px solid #e5e7eb;" />'
                : '<div style="width:48px;height:48px;border-radius:6px;background:#f3f4f6;display:inline-block;"></div>';

            $itemsHtml .= <<<ITEM
            <tr style="background:{$bgColor};">
                <td style="padding:12px 10px;border-bottom:1px solid #e5e7eb;text-align:center;">{$imgTag}</td>
                <td style="padding:12px 10px;border-bottom:1px solid #e5e7eb;font-size:14px;color:#1f2937;">
                    <strong>{$productName}</strong>
                    <div style="font-size:12px;color:#6b7280;margin-top:2px;">SKU: {$sku}</div>
                </td>
                <td style="padding:12px 10px;border-bottom:1px solid #e5e7eb;text-align:center;font-size:14px;color:#374151;">{$qty}</td>
                <td style="padding:12px 10px;border-bottom:1px solid #e5e7eb;text-align:right;font-size:14px;color:#374151;white-space:nowrap;">{$currency} <span style="font-weight:600;">{$currencyCode}</span> {$unitPrice}</td>
                <td style="padding:12px 10px;border-bottom:1px solid #e5e7eb;text-align:right;font-size:14px;color:#1f2937;font-weight:600;white-space:nowrap;">{$currency} <span style="font-weight:600;">{$currencyCode}</span> {$totalPrice}</td>
            </tr>
ITEM;
        }

        $subtotal = (float)($order['subtotal'] ?? 0);
        $discount = (float)($order['discount'] ?? 0);
        $tax = (float)($order['tax'] ?? 0);
        $shipping = (float)($order['shipping_cost'] ?? 0);
        $total = (float)($order['total'] ?? 0);
        $couponCode = htmlspecialchars($order['coupon_code'] ?? '', ENT_QUOTES, 'UTF-8');

        $discountLabel = $couponCode ? "Discount ({$couponCode})" : 'Discount';

        $subtotalFormatted = number_format($subtotal, 2);
        $discountFormatted = number_format($discount, 2);
        $taxFormatted = number_format($tax, 2);
        $shippingFormatted = number_format($shipping, 2);
        $totalFormatted = number_format($total, 2);

        $billingName = htmlspecialchars($order['billing_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
        $billingAddress = htmlspecialchars($order['billing_address'] ?? '', ENT_QUOTES, 'UTF-8');
        $billingCity = htmlspecialchars($order['billing_city'] ?? '', ENT_QUOTES, 'UTF-8');
        $billingState = htmlspecialchars($order['billing_state'] ?? '', ENT_QUOTES, 'UTF-8');
        $billingPincode = htmlspecialchars($order['billing_pincode'] ?? '', ENT_QUOTES, 'UTF-8');
        $billingEmail = htmlspecialchars($order['email'] ?? '', ENT_QUOTES, 'UTF-8');
        $billingPhone = htmlspecialchars($order['phone'] ?? '', ENT_QUOTES, 'UTF-8');

        $shippingName = htmlspecialchars($order['shipping_name'] ?? $billingName, ENT_QUOTES, 'UTF-8');
        $shippingAddress = htmlspecialchars($order['shipping_address'] ?? $billingAddress, ENT_QUOTES, 'UTF-8');
        $shippingCity = htmlspecialchars($order['shipping_city'] ?? $billingCity, ENT_QUOTES, 'UTF-8');
        $shippingState = htmlspecialchars($order['shipping_state'] ?? $billingState, ENT_QUOTES, 'UTF-8');
        $shippingPincode = htmlspecialchars($order['shipping_pincode'] ?? $billingPincode, ENT_QUOTES, 'UTF-8');

        $billingFull = $billingAddress ? "{$billingAddress}, {$billingCity}, {$billingState} - {$billingPincode}" : '';
        $shippingFull = $shippingAddress ? "{$shippingAddress}, {$shippingCity}, {$shippingState} - {$shippingPincode}" : '';

        $orderNumber = htmlspecialchars($order['order_number'] ?? '', ENT_QUOTES, 'UTF-8');

        $logoSection = '';
        if ($logo) {
            $logoSection = '<img src="' . htmlspecialchars($logo, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8') . '" style="max-height:64px;margin-bottom:8px;" />';
        }

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Invoice {$invoiceNumber}</title>
<style>
    @page { margin: 20mm 15mm; }
    body { font-family: 'Helvetica Neue', Arial, sans-serif; margin: 0; padding: 0; color: #374151; font-size: 14px; line-height: 1.5; }
    .invoice-container { max-width: 800px; margin: 0 auto; padding: 40px 30px; }
    .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid #1e293b; }
    .company-info h1 { margin: 0 0 4px 0; font-size: 26px; color: #1e293b; font-weight: 800; letter-spacing: -0.5px; }
    .company-info p { margin: 2px 0; color: #6b7280; font-size: 13px; }
    .invoice-title { text-align: right; }
    .invoice-title h2 { margin: 0 0 6px 0; font-size: 28px; color: #1e293b; font-weight: 800; }
    .invoice-title .badge { margin-top: 8px; display: inline-block; }
    .invoice-meta { width: 100%; margin-bottom: 24px; }
    .invoice-meta td { padding: 6px 12px; font-size: 13px; }
    .invoice-meta td:first-child { color: #6b7280; font-weight: 600; width: 140px; }
    .invoice-meta td:last-child { color: #1f2937; font-weight: 500; }
    .address-section { display: flex; gap: 30px; margin-bottom: 30px; }
    .address-box { flex: 1; padding: 16px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; }
    .address-box h3 { margin: 0 0 8px 0; font-size: 14px; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; }
    .address-box p { margin: 3px 0; font-size: 13px; color: #334155; }
    .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .items-table thead th { background: #1e293b; color: #fff; padding: 12px 10px; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; }
    .items-table thead th:first-child { border-radius: 8px 0 0 0; width: 60px; }
    .items-table thead th:last-child { border-radius: 0 8px 0 0; }
    .totals { margin-left: auto; width: 340px; margin-bottom: 30px; }
    .totals table { width: 100%; border-collapse: collapse; }
    .totals td { padding: 8px 14px; font-size: 14px; }
    .totals td:first-child { color: #6b7280; font-weight: 500; }
    .totals td:last-child { text-align: right; font-weight: 600; color: #1f2937; }
    .totals .grand-total td { font-size: 18px; font-weight: 800; color: #1e293b; padding: 12px 14px; border-top: 2px solid #1e293b; }
    .totals .grand-total td:first-child { color: #1e293b; }
    .payment-info { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 16px 20px; margin-bottom: 24px; }
    .payment-info h3 { margin: 0 0 6px 0; font-size: 14px; color: #166534; font-weight: 700; }
    .payment-info p { margin: 2px 0; font-size: 13px; color: #15803d; }
    .footer { margin-top: 30px; padding-top: 20px; border-top: 2px solid #e2e8f0; }
    .footer table { width: 100%; }
    .footer td { vertical-align: top; padding: 8px 12px; font-size: 12px; color: #6b7280; }
    .footer td:first-child { width: 50%; }
    .footer h4 { margin: 0 0 6px 0; font-size: 13px; color: #475569; font-weight: 700; }
    .footer p { margin: 2px 0; }
    .page-break { page-break-after: always; }
    @media print {
        body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .no-print { display: none; }
    }
</style>
</head>
<body>
<div class="invoice-container">
    <div class="header">
        <div class="company-info">
            {$logoSection}
            <h1>{$companyName}</h1>
            <p>{$companyAddress}</p>
            <p>Phone: {$companyPhone} | Email: {$companyEmail}</p>
        </div>
        <div class="invoice-title">
            <h2>INVOICE</h2>
            <div style="font-size:16px;font-weight:700;color:#475569;margin-bottom:4px;">{$invoiceNumber}</div>
            <div style="font-size:13px;color:#6b7280;">Date: {$orderDate}</div>
            <div class="badge">{$paymentBadge}</div>
        </div>
    </div>

    <table class="invoice-meta">
        <tr><td>Order Number</td><td>{$orderNumber}</td></tr>
        <tr><td>Invoice Date</td><td>{$orderDate}</td></tr>
        <tr><td>Due Date</td><td>{$dueDate}</td></tr>
    </table>

    <div class="address-section">
        <div class="address-box">
            <h3>Bill To</h3>
            <p><strong>{$billingName}</strong></p>
            <p>{$billingFull}</p>
            <p>Email: {$billingEmail}</p>
            <p>Phone: {$billingPhone}</p>
        </div>
        <div class="address-box">
            <h3>Ship To</h3>
            <p><strong>{$shippingName}</strong></p>
            <p>{$shippingFull}</p>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th style="text-align:left;">Product</th>
                <th>Qty</th>
                <th style="text-align:right;">Unit Price</th>
                <th style="text-align:right;">Total</th>
            </tr>
        </thead>
        <tbody>
            {$itemsHtml}
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr><td>Subtotal</td><td>{$currency} {$subtotalFormatted}</td></tr>
            <tr><td>{$discountLabel}</td><td style="color:#dc2626;">- {$currency} {$discountFormatted}</td></tr>
            <tr><td>{$taxName} ({$taxRate}%)</td><td>{$currency} {$taxFormatted}</td></tr>
            <tr><td>Shipping</td><td>{$currency} {$shippingFormatted}</td></tr>
            <tr class="grand-total"><td>Total</td><td>{$currency} {$totalFormatted}</td></tr>
        </table>
    </div>

    <div class="payment-info">
        <h3>Payment Information</h3>
        <p>Method: <strong>{$paymentMethodLabel}</strong></p>
        <p>Status: {$paymentBadge}</p>
    </div>

    <div class="footer">
        <table>
            <tr>
                <td>
                    <h4>Bank Details</h4>
                    <p>{$bankDetails}</p>
                </td>
                <td>
                    <h4>Terms & Conditions</h4>
                    <p>{$terms}</p>
                </td>
            </tr>
        </table>
        <div style="text-align:center;margin-top:16px;padding-top:12px;border-top:1px solid #e5e7eb;font-size:11px;color:#9ca3af;">
            Generated on {$orderDate} | {$companyName} | Thank you for your business!
        </div>
    </div>
</div>
</body>
</html>
HTML;
    }

    public static function getNextInvoiceNumber(): string
    {
        $prefix = 'INV-' . date('Y') . '-';
        $lastId = 0;

        $files = glob(self::INVOICES_DIR . '/invoice-*.html');
        if ($files) {
            $numbers = [];
            foreach ($files as $file) {
                $basename = basename($file);
                if (preg_match('/invoice-INV-\d{4}-(\d+)\.html/', $basename, $m)) {
                    $numbers[] = (int)$m[1];
                }
            }
            if ($numbers) {
                $lastId = max($numbers);
            }
        }

        try {
            $pdo = \App\Core\Database::getInstance()->getConnection();
            $stmt = $pdo->query("SELECT MAX(CAST(SUBSTRING_INDEX(invoice_number, '-', -1) AS UNSIGNED)) FROM sg_orders WHERE invoice_number LIKE '{$prefix}%'");
            $maxDb = (int)$stmt->fetchColumn();
            if ($maxDb > $lastId) {
                $lastId = $maxDb;
            }
        } catch (\Exception $e) {
        }

        return $prefix . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
    }

    private static function getProductImageUrl(int $productId): string
    {
        try {
            $product = \App\Models\Product::find($productId);
            if ($product && !empty($product->image)) {
                return \App\Helpers\Image::url($product->image, 'thumb');
            }
        } catch (\Exception $e) {
        }
        return '';
    }

    private static function getSettings(): array
    {
        $keys = [
            'currency', 'currency_code', 'company_name', 'company_address',
            'company_phone', 'company_email', 'bank_details', 'invoice_terms',
            'tax_name', 'tax_rate', 'logo_url',
        ];
        $settings = [];
        foreach ($keys as $key) {
            try {
                $settings[$key] = Setting::get('invoice_' . $key);
            } catch (\Exception $e) {
                $settings[$key] = null;
            }
        }
        return $settings;
    }

    private static function ensureDirectory(): void
    {
        if (!is_dir(self::INVOICES_DIR)) {
            mkdir(self::INVOICES_DIR, 0755, true);
        }
    }

    private static function generateWithTcpdf(string $html, string $filepath, bool $download): string
    {
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(APP_NAME);
        $pdf->SetAuthor(APP_NAME);
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Invoice');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        if ($download) {
            $pdf->Output(basename($filepath), 'D');
            exit;
        }

        $pdf->Output($filepath, 'F');
        return $filepath;
    }
}
