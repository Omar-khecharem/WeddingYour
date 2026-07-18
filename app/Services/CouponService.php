<?php
/**
 * Coupon Service
 * 
 * Manages coupon validation, application, and usage tracking
 * including percentage discounts, fixed amount, and conditional rules.
 *
 * @package App\Services
 */

namespace App\Services;

use App\Core\Database;

class CouponService
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Validate a coupon code
     */
    public function validate(string $code, float $orderAmount = 0, ?int $userId = null): array
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("
            SELECT * FROM sg_coupons 
            WHERE code = :code AND is_active = 1 
            AND (expires_at IS NULL OR expires_at > NOW()) 
            AND (starts_at IS NULL OR starts_at <= NOW())
        ");
        $stmt->execute([':code' => $code]);
        $coupon = $stmt->fetch();

        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid or expired coupon code.'];
        }

        // Check usage limit
        if ($coupon['usage_limit'] && (int)$coupon['used_count'] >= (int)$coupon['usage_limit']) {
            return ['valid' => false, 'message' => 'This coupon has reached its usage limit.'];
        }

        // Check per-user limit
        if ($coupon['usage_per_user'] && $userId) {
            $stmt = $pdo->prepare("
                SELECT COUNT(*) FROM sg_orders 
                WHERE coupon_code = :code AND user_id = :user_id 
                AND order_status NOT IN ('cancelled', 'refunded')
            ");
            $stmt->execute([':code' => $code, ':user_id' => $userId]);
            $userUsage = (int)$stmt->fetchColumn();
            if ($userUsage >= (int)$coupon['usage_per_user']) {
                return ['valid' => false, 'message' => 'You have already used this coupon.'];
            }
        }

        // Check minimum order amount
        if ($coupon['min_order_amount'] && $orderAmount < (float)$coupon['min_order_amount']) {
            return ['valid' => false, 'message' => 'Minimum order amount of ₹' . number_format((float)$coupon['min_order_amount']) . ' required.'];
        }

        // Calculate discount
        $discount = $this->calculateDiscount($coupon, $orderAmount);

        return [
            'valid' => true,
            'coupon' => $coupon,
            'discount' => $discount,
            'message' => 'Coupon applied successfully!',
        ];
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount(array $coupon, float $orderAmount): float
    {
        if ($coupon['type'] === 'percentage') {
            $discount = $orderAmount * ((float)$coupon['value'] / 100);
            if ($coupon['max_discount']) {
                $discount = min($discount, (float)$coupon['max_discount']);
            }
        } else {
            $discount = min((float)$coupon['value'], $orderAmount);
        }

        return max(0, $discount);
    }

    /**
     * Get active coupons (frontend)
     */
    public function getActiveCoupons(): array
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->query("
            SELECT * FROM sg_coupons 
            WHERE is_active = 1 
            AND (expires_at IS NULL OR expires_at > NOW()) 
            AND (starts_at IS NULL OR starts_at <= NOW())
            ORDER BY created_at DESC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Get all coupons (admin)
     */
    public function getAllCoupons(): array
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->query("
            SELECT * FROM sg_coupons 
            ORDER BY created_at DESC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Increment coupon usage
     */
    public function incrementUsage(int $couponId): void
    {
        $pdo = $this->db->getConnection();
        $pdo->prepare("UPDATE sg_coupons SET used_count = used_count + 1 WHERE id = :id")
            ->execute([':id' => $couponId]);
    }

    /**
     * Create a new coupon
     */
    public function create(array $data): array
    {
        $pdo = $this->db->getConnection();
        $code = strtoupper($data['code']);

        $check = $pdo->prepare("SELECT id FROM sg_coupons WHERE code = :code");
        $check->execute([':code' => $code]);
        if ($check->fetch()) {
            return ['success' => false, 'message' => 'A coupon with this code already exists.'];
        }

        $stmt = $pdo->prepare("
            INSERT INTO sg_coupons (code, type, value, min_order_amount, max_discount, usage_limit, usage_per_user, is_active, starts_at, expires_at, description)
            VALUES (:code, :type, :value, :min_order, :max_discount, :usage_limit, :usage_per_user, :is_active, :starts_at, :expires_at, :description)
        ");
        $stmt->execute([
            ':code' => $code,
            ':type' => $data['type'],
            ':value' => $data['value'],
            ':min_order' => $data['min_order_amount'] ?? null,
            ':max_discount' => $data['max_discount'] ?? null,
            ':usage_limit' => $data['usage_limit'] ?? null,
            ':usage_per_user' => $data['usage_per_user'] ?? 1,
            ':is_active' => $data['is_active'] ?? 1,
            ':starts_at' => $data['starts_at'] ?? null,
            ':expires_at' => $data['expires_at'] ?? null,
            ':description' => $data['description'] ?? '',
        ]);

        return ['success' => true, 'id' => (int)$pdo->lastInsertId(), 'code' => $code];
    }

    /**
     * Update coupon
     */
    public function update(int $id, array $data): bool
    {
        $pdo = $this->db->getConnection();
        $sets = [];
        $params = [':id' => $id];

        $allowed = ['type', 'value', 'min_order_amount', 'max_discount', 'usage_limit', 'usage_per_user', 'is_active', 'starts_at', 'expires_at', 'description'];
        foreach ($allowed as $field) {
            if (isset($data[$field])) {
                $sets[] = "{$field} = :{$field}";
                $params[":{$field}"] = $data[$field];
            }
        }

        if (empty($sets)) return false;

        $sql = "UPDATE sg_coupons SET " . implode(', ', $sets) . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Delete coupon
     */
    public function delete(int $id): bool
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("DELETE FROM sg_coupons WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
