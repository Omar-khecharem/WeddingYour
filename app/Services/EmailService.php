<?php
/**
 * Email Service
 * 
 * Handles transactional email sending for order confirmations,
 * password resets, newsletters, and notifications.
 *
 * @package App\Services
 */

namespace App\Services;

use App\Core\View;

class EmailService
{
    private string $fromEmail;
    private string $fromName;

    public function __construct()
    {
        $this->fromEmail = CONTACT_EMAIL;
        $this->fromName = APP_NAME;
    }

    /**
     * Send an email
     */
    public function send(string $to, string $subject, string $body, bool $isHtml = true): bool
    {
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: ' . ($isHtml ? 'text/html' : 'text/plain') . '; charset=UTF-8',
            'From: ' . $this->fromName . ' <' . $this->fromEmail . '>',
            'Reply-To: ' . $this->fromEmail,
            'X-Mailer: PHP/' . phpversion(),
        ];

        return mail($to, $subject, $body, implode("\r\n", $headers));
    }

    /**
     * Send order confirmation
     */
    public function sendOrderConfirmation(string $email, array $order): bool
    {
        $subject = 'Order Confirmation - ' . $order['order_number'];

        $items = array_map(function ($item) {
            return array_merge($item, [
                'qty' => $item['quantity'] ?? $item['qty'] ?? 0,
                'price' => $item['unit_price'] ?? $item['price'] ?? 0,
            ]);
        }, $order['items'] ?? []);

        $order['items'] = $items;
        $order['shipping_method_name'] = $order['shipping_method_name'] ?? ($order['shipping_method'] ?? 'Standard');
        $order['payment_method_name'] = $order['payment_method_name'] ?? ($order['payment_method'] ?? 'COD');

        $body = View::renderPartial('emails.order-confirmation', [
            'order' => $order,
            'items' => $items,
        ]);

        return $this->send($email, $subject, $body);
    }

    /**
     * Send order status update
     */
    public function sendOrderStatusUpdate(string $email, array $order): bool
    {
        $subject = 'Order Status Update - ' . $order['order_number'];

        $statusLabels = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'refunded' => 'Refunded',
        ];

        $body = View::renderPartial('emails.order-status', [
            'order' => $order,
            'statusLabels' => $statusLabels,
            'oldStatus' => $order['previous_status'] ?? 'pending',
            'newStatus' => $order['order_status'],
        ]);

        return $this->send($email, $subject, $body);
    }

    /**
     * Send password reset email
     */
    public function sendPasswordReset(string $email, string $token): bool
    {
        $subject = 'Reset Your ' . APP_NAME . ' Password';
        $resetUrl = url('reset-password/' . $token);

        $body = View::renderPartial('emails.password-reset', [
            'name' => $email,
            'resetLink' => $resetUrl,
        ]);

        return $this->send($email, $subject, $body);
    }

    /**
     * Send welcome email
     */
    public function sendWelcome(string $email, string $name): bool
    {
        $subject = 'Welcome to ' . APP_NAME . '!';

        $body = View::renderPartial('emails.welcome', [
            'name' => $name,
            'email' => $email,
            'shopLink' => url('products'),
        ]);

        return $this->send($email, $subject, $body);
    }

    /**
     * Send contact inquiry
     */
    public function sendContactInquiry(array $data): bool
    {
        $subject = 'New Contact Inquiry from ' . $data['name'];

        $body = View::renderPartial('emails.contact-inquiry', [
            'data' => [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? 'N/A',
                'subject' => $data['subject'] ?? 'Contact Inquiry',
                'message' => $data['message'],
            ],
        ]);

        return $this->send($this->fromEmail, $subject, $body);
    }

    /**
     * Send newsletter
     */
    public function sendNewsletter(string $email, string $subject, string $content): bool
    {
        $body = View::renderPartial('emails.newsletter', [
            'content' => $content,
            'email' => $email,
            'unsubscribe_url' => url('newsletter/unsubscribe?email=' . urlencode($email)),
        ]);

        return $this->send($email, $subject, $body);
    }

    /**
     * Send notification to admin
     */
    public function sendAdminNotification(string $type, array $data): bool
    {
        $subject = APP_NAME . ' Admin Notification: ' . ucfirst($type);

        $body = View::renderPartial('emails.admin-notification', [
            'type' => $type,
            'data' => $data,
        ]);

        return $this->send($this->fromEmail, $subject, $body);
    }
}
