<?php
/**
 * Payment Service
 * 
 * Abstract payment processing with support for COD (Cash on Delivery),
 * and extensible interface for gateway integrations (Razorpay, PayU, etc.).
 *
 * @package App\Services
 */

namespace App\Services;

use App\Core\Database;

class PaymentService
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Process COD payment
     */
    public function processCOD(int $orderId): array
    {
        // COD is processed on delivery; just mark as pending
        return [
            'success' => true,
            'status' => 'pending',
            'message' => 'Order placed successfully. Pay on delivery.',
        ];
    }

    /**
     * Process Razorpay payment
     */
    public function processRazorpay(int $orderId, array $paymentData): array
    {
        $order = (new OrderService())->getOrder($orderId);
        if (!$order) {
            return ['success' => false, 'message' => 'Order not found.'];
        }

        // Verify Razorpay payment signature
        $expectedSignature = hash_hmac(
            'sha256',
            $paymentData['razorpay_order_id'] . '|' . $paymentData['razorpay_payment_id'],
            $this->getRazorpaySecret()
        );

        if ($expectedSignature !== ($paymentData['razorpay_signature'] ?? '')) {
            return ['success' => false, 'message' => 'Payment verification failed.'];
        }

        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("
            UPDATE sg_orders SET 
                payment_status = 'completed', 
                payment_id = :payment_id, 
                is_paid = 1,
                order_status = 'confirmed'
            WHERE id = :id
        ");
        $stmt->execute([
            ':payment_id' => $paymentData['razorpay_payment_id'],
            ':id' => $orderId
        ]);

        return [
            'success' => true,
            'status' => 'completed',
            'payment_id' => $paymentData['razorpay_payment_id'],
            'message' => 'Payment successful.',
        ];
    }

    /**
     * Get available payment methods
     */
    public function getPaymentMethods(): array
    {
        return [
            [
                'id' => 'cod',
                'name' => 'Cash on Delivery',
                'description' => 'Pay when you receive your order',
                'icon' => 'fa-solid fa-money-bill-wave',
                'is_active' => true,
            ],
            // [
            //     'id' => 'razorpay',
            //     'name' => 'Pay Online (Card/UPI/Net Banking)',
            //     'description' => 'Secure payment via Razorpay',
            //     'icon' => 'fa-solid fa-credit-card',
            //     'is_active' => $this->isRazorpayConfigured(),
            // ],
        ];
    }

    /**
     * Check if Razorpay is configured
     */
    private function isRazorpayConfigured(): bool
    {
        return defined('RAZORPAY_KEY_ID') && RAZORPAY_KEY_ID !== '';
    }

    /**
     * Get Razorpay key ID
     */
    public function getRazorpayKey(): string
    {
        return defined('RAZORPAY_KEY_ID') ? RAZORPAY_KEY_ID : '';
    }

    /**
     * Get Razorpay secret
     */
    private function getRazorpaySecret(): string
    {
        return defined('RAZORPAY_KEY_SECRET') ? RAZORPAY_KEY_SECRET : '';
    }

    /**
     * Create Razorpay order
     */
    public function createRazorpayOrder(int $orderId): ?array
    {
        $order = (new OrderService())->getOrder($orderId);
        if (!$order) return null;

        // In production, integrate with Razorpay API here
        // For now, return a mock order
        return [
            'id' => 'order_' . uniqid(),
            'amount' => (int)($order['total'] * 100), // paise
            'currency' => 'INR',
            'receipt' => $order['order_number'],
        ];
    }
}
