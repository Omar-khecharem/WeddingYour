<?php
/**
 * Wishlist Model
 * 
 * Manages user wishlist items with add/remove/toggle functionality.
 *
 * @package App\Models
 */

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Wishlist extends Model
{
    protected static string $table = 'wishlists';
    protected static array $fillable = ['user_id', 'product_id'];

    /**
     * Toggle wishlist item (add if not exists, remove if exists)
     */
    public static function toggle(int $userId, int $productId): array
    {
        $pdo = Database::getInstance()->getConnection();

        $stmt = $pdo->prepare("SELECT id FROM sg_wishlist WHERE user_id = :uid AND product_id = :pid LIMIT 1");
        $stmt->execute([':uid' => $userId, ':pid' => $productId]);
        $existing = $stmt->fetch();

        if ($existing) {
            $stmt = $pdo->prepare("DELETE FROM sg_wishlist WHERE id = :id");
            $stmt->execute([':id' => $existing['id']]);
            return ['success' => true, 'action' => 'removed', 'message' => 'Removed from wishlist.'];
        } else {
            $stmt = $pdo->prepare("INSERT INTO sg_wishlist (user_id, product_id) VALUES (:uid, :pid)");
            $stmt->execute([':uid' => $userId, ':pid' => $productId]);
            return ['success' => true, 'action' => 'added', 'message' => 'Added to wishlist!'];
        }
    }

    /**
     * Get user wishlist with product details
     */
    public static function getUserWishlist(int $userId): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            SELECT w.id as wishlist_id, w.created_at as added_at,
                   p.*, c.name AS category_name, sc.name AS subcategory_name,
                   (SELECT image FROM sg_product_images WHERE product_id = p.id ORDER BY is_primary DESC, sort_order ASC LIMIT 1) as image
            FROM sg_wishlist w
            JOIN sg_products p ON p.id = w.product_id
            LEFT JOIN sg_categories c ON c.id = p.category_id
            LEFT JOIN sg_subcategories sc ON sc.id = p.subcategory_id
            WHERE w.user_id = :uid AND p.status = 1
            ORDER BY w.created_at DESC
        ");
        $stmt->execute([':uid' => $userId]);

        $items = $stmt->fetchAll();
        foreach ($items as &$item) {
            $img = $item['image'] ?? '';
            $item['image'] = $img
                ? uploadUrl($img, 'products')
                : asset('images/placeholder.png');
        }

        return $items;
    }

    /**
     * Check if product is in user wishlist
     */
    public static function isInWishlist(int $userId, int $productId): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM sg_wishlist WHERE user_id = :uid AND product_id = :pid");
        $stmt->execute([':uid' => $userId, ':pid' => $productId]);
        return (int)$stmt->fetchColumn() > 0;
    }

    /**
     * Get wishlist count
     */
    public static function getCount(int $userId): int
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM sg_wishlist WHERE user_id = :uid");
        $stmt->execute([':uid' => $userId]);
        return (int)$stmt->fetchColumn();
    }
}
