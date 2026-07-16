<?php

namespace App\Services;

use App\Models\Setting;

class WhatsAppService
{
    public static function getNumber(): string
    {
        $number = Setting::get('whatsapp_number');

        if ($number) {
            return preg_replace('/[^0-9]/', '', $number);
        }

        return WHATSAPP_NUMBER;
    }

    public static function formatOrderMessage(array $order): string
    {
        $lines = [];
        $lines[] = "🛒 *New Order #{$order['order_number']}*";
        $lines[] = "📅 " . date('d/m/Y H:i', strtotime($order['created_at'] ?? 'now'));
        $lines[] = "";

        if (!empty($order['items'])) {
            $lines[] = "📦 *Ordered Items:*";
            foreach ($order['items'] as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                $lines[] = "  • {$item['name']} x{$item['quantity']} = " . number_format($subtotal, 2) . " " . APP_CURRENCY;
            }
            $lines[] = "";
        }

        $lines[] = "💰 *Total:* " . number_format($order['total'] ?? 0, 2) . " " . APP_CURRENCY;

        if (!empty($order['delivery_address'])) {
            $addr = $order['delivery_address'];
            $lines[] = "";
            $lines[] = "📍 *Shipping Address:*";
            $lines[] = "  {$addr['name']}";
            $lines[] = "  {$addr['street']}";
            if (!empty($addr['city'])) {
                $lines[] = "  {$addr['postcode']} {$addr['city']}";
            }
        }

        if (!empty($order['payment_method'])) {
            $lines[] = "";
            $lines[] = "💳 *Payment:* {$order['payment_method']}";
        }

        if (!empty($order['notes'])) {
            $lines[] = "";
            $lines[] = "📝 *Notes :* {$order['notes']}";
        }

        return implode("\n", $lines);
    }

    public static function sendOrder(array $order): string
    {
        $number = self::getNumber();
        $message = self::formatOrderMessage($order);

        return 'https://wa.me/' . $number . '?text=' . urlencode($message);
    }

    public static function sendStatusUpdate(array $order): string
    {
        $number = self::getNumber();

        $lines = [];
        $lines[] = "🔄 *Order Update #{$order['order_number']}*";
        $lines[] = "📅 " . date('d/m/Y H:i');
        $lines[] = "";
        $lines[] = "📌 *Statut :* {$order['status']}";

        if (!empty($order['status_note'])) {
            $lines[] = "📝 *Note :* {$order['status_note']}";
        }

        $message = implode("\n", $lines);

        return 'https://wa.me/' . $number . '?text=' . urlencode($message);
    }
}
