<?php
namespace App\Models;

use App\Core\Model;

class Compare extends Model
{
    protected static string $table = 'sg_compare';
    protected static string $primaryKey = 'id';
    protected static array $fillable = ['user_id', 'session_id', 'product_id'];

    public static function toggle(?int $userId, ?string $sessionId, int $productId): array
    {
        $db = self::db();
        if ($userId) {
            $stmt = $db->prepare("SELECT id FROM sg_compare WHERE user_id = :u AND product_id = :p LIMIT 1");
            $stmt->execute([':u' => $userId, ':p' => $productId]);
        } else {
            $stmt = $db->prepare("SELECT id FROM sg_compare WHERE session_id = :s AND product_id = :p LIMIT 1");
            $stmt->execute([':s' => $sessionId, ':p' => $productId]);
        }
        $existing = $stmt->fetch();
        if ($existing) {
            $del = $db->prepare("DELETE FROM sg_compare WHERE id = :id");
            $del->execute([':id' => $existing['id']]);
            return ['action' => 'removed', 'count' => self::getCount($userId, $sessionId)];
        }
        $ins = $db->prepare("INSERT INTO sg_compare (user_id, session_id, product_id) VALUES (:u, :s, :p)");
        $ins->execute([':u' => $userId, ':s' => $sessionId, ':p' => $productId]);
        return ['action' => 'added', 'count' => self::getCount($userId, $sessionId)];
    }

    public static function getList(?int $userId, ?string $sessionId): array
    {
        $db = self::db();
        if ($userId) {
            $stmt = $db->prepare("SELECT c.*, p.name, p.slug, p.regular_price, p.sale_price, p.discount_percent, p.stock_status, p.rating_avg, p.rating_count, pi.image AS primary_image, cat.name AS category_name FROM sg_compare c JOIN sg_products p ON c.product_id = p.id LEFT JOIN sg_product_images pi ON p.id = pi.product_id AND pi.is_primary = 1 LEFT JOIN sg_categories cat ON p.category_id = cat.id WHERE c.user_id = :u ORDER BY c.created_at DESC");
            $stmt->execute([':u' => $userId]);
        } else {
            $stmt = $db->prepare("SELECT c.*, p.name, p.slug, p.regular_price, p.sale_price, p.discount_percent, p.stock_status, p.rating_avg, p.rating_count, pi.image AS primary_image, cat.name AS category_name FROM sg_compare c JOIN sg_products p ON c.product_id = p.id LEFT JOIN sg_product_images pi ON p.id = pi.product_id AND pi.is_primary = 1 LEFT JOIN sg_categories cat ON p.category_id = cat.id WHERE c.session_id = :s ORDER BY c.created_at DESC");
            $stmt->execute([':s' => $sessionId]);
        }
        return $stmt->fetchAll();
    }

    public static function getCount(?int $userId, ?string $sessionId): int
    {
        $db = self::db();
        if ($userId) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM sg_compare WHERE user_id = :u");
            $stmt->execute([':u' => $userId]);
        } else {
            $stmt = $db->prepare("SELECT COUNT(*) FROM sg_compare WHERE session_id = :s");
            $stmt->execute([':s' => $sessionId]);
        }
        return (int) $stmt->fetchColumn();
    }

    public static function isInCompare(?int $userId, ?string $sessionId, int $productId): bool
    {
        $db = self::db();
        if ($userId) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM sg_compare WHERE user_id = :u AND product_id = :p");
            $stmt->execute([':u' => $userId, ':p' => $productId]);
        } else {
            $stmt = $db->prepare("SELECT COUNT(*) FROM sg_compare WHERE session_id = :s AND product_id = :p");
            $stmt->execute([':s' => $sessionId, ':p' => $productId]);
        }
        return $stmt->fetchColumn() > 0;
    }

    public static function clear(?int $userId, ?string $sessionId): void
    {
        $db = self::db();
        if ($userId) {
            $db->prepare("DELETE FROM sg_compare WHERE user_id = :u")->execute([':u' => $userId]);
        } else {
            $db->prepare("DELETE FROM sg_compare WHERE session_id = :s")->execute([':s' => $sessionId]);
        }
    }
}
