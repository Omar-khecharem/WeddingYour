<?php
/**
 * Order Model
 * 
 * Represents a customer order with items, payment info,
 * shipping details, and status tracking.
 *
 * @package App\Models
 */

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Order extends Model
{
    protected static string $table = 'orders';
    protected static array $fillable = [
        'order_number', 'user_id', 'email', 'phone',
        'billing_name', 'billing_address', 'billing_city', 'billing_state', 'billing_pincode',
        'shipping_name', 'shipping_address', 'shipping_city', 'shipping_state', 'shipping_pincode',
        'subtotal', 'discount', 'tax', 'shipping_cost', 'total',
        'coupon_code', 'coupon_discount',
        'payment_method', 'payment_status', 'payment_id',
        'order_status', 'shipping_method', 'tracking_number',
        'notes', 'is_paid', 'invoice_number'
    ];

    /**
     * Get order items
     */
    public function getItems(): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM sg_order_items WHERE order_id = :id");
        $stmt->execute([':id' => $this->attributes['id']]);
        return $stmt->fetchAll();
    }

    /**
     * Get order by number
     */
    public static function findByNumber(string $orderNumber): ?array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM sg_orders WHERE order_number = :number LIMIT 1");
        $stmt->execute([':number' => $orderNumber]);
        $order = $stmt->fetch();
        return $order ?: null;
    }

    /**
     * Get order statuses with counts
     */
    public static function getStatusCounts(): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("
            SELECT order_status, COUNT(*) as count
            FROM sg_orders
            GROUP BY order_status
        ");
        $counts = [];
        foreach ($stmt->fetchAll() as $row) {
            $counts[$row['order_status']] = (int)$row['count'];
        }
        return $counts;
    }

    /**
     * Get daily sales for the last N days
     */
    public static function getDailySales(int $days = 30): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            SELECT DATE(created_at) as date, COUNT(*) as orders, SUM(total) as revenue
            FROM sg_orders
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL :days DAY)
            AND order_status NOT IN ('cancelled', 'refunded')
            GROUP BY DATE(created_at)
            ORDER BY date ASC
        ");
        $stmt->bindValue(':days', $days, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get monthly sales for the current year
     */
    public static function getMonthlySales(): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("
            SELECT MONTH(created_at) as month, COUNT(*) as orders, SUM(total) as revenue
            FROM sg_orders
            WHERE YEAR(created_at) = YEAR(CURDATE())
            AND order_status NOT IN ('cancelled', 'refunded')
            GROUP BY MONTH(created_at)
            ORDER BY month ASC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Get recent orders with user info
     */
    public static function getRecentWithUser(int $limit = 10): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            SELECT o.*, u.name as user_name, u.email as user_email
            FROM sg_orders o
            LEFT JOIN sg_users u ON u.id = o.user_id
            ORDER BY o.created_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
