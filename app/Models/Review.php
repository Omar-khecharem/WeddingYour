<?php
/**
 * Review Model
 * 
 * Represents a product review/customer testimonial with
 * rating, verification, and moderation support.
 *
 * @package App\Models
 */

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Review extends Model
{
    protected static string $table = 'reviews';
    protected static array $fillable = [
        'product_id', 'user_id', 'name', 'email', 'rating',
        'title', 'comment', 'images', 'is_verified', 'is_approved'
    ];

    /**
     * Get approved reviews for a product
     */
    public static function getApprovedForProduct(int $productId, int $limit = 10): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            SELECT r.*, u.avatar 
            FROM sg_reviews r
            LEFT JOIN sg_users u ON u.id = r.user_id
            WHERE r.product_id = :pid AND r.is_approved = 1
            ORDER BY r.created_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':pid', $productId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get latest approved reviews
     */
    public static function getApproved(int $limit = 3): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            SELECT r.*, u.avatar, p.name as product_name
            FROM sg_reviews r
            LEFT JOIN sg_users u ON u.id = r.user_id
            LEFT JOIN sg_products p ON p.id = r.product_id
            WHERE r.is_approved = 1
            ORDER BY r.created_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get average ratings for multiple products at once
     * Returns [product_id => ['average' => float, 'total' => int], ...]
     */
    public static function getBatchRatings(array $productIds): array
    {
        if (empty($productIds)) return [];
        $pdo = Database::getInstance()->getConnection();
        $ids = implode(',', array_map('intval', $productIds));
        $stmt = $pdo->query("SELECT product_id, AVG(rating) as avg_rating, COUNT(*) as total FROM sg_reviews WHERE product_id IN ($ids) AND is_approved = 1 GROUP BY product_id");
        $result = [];
        foreach ($stmt->fetchAll() as $row) {
            $result[(int)$row['product_id']] = [
                'average' => round((float)$row['avg_rating'], 1),
                'total' => (int)$row['total'],
            ];
        }
        return $result;
    }

    /**
     * Get product average rating
     */
    public static function getAverageRating(int $productId): float
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            SELECT AVG(rating) as avg_rating, COUNT(*) as total
            FROM sg_reviews
            WHERE product_id = :pid AND is_approved = 1
        ");
        $stmt->execute([':pid' => $productId]);
        $result = $stmt->fetch();
        return (float)($result['avg_rating'] ?? 0);
    }

    /**
     * Get pending reviews for moderation
     */
    public static function getPending(): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("
            SELECT r.*, p.name as product_name
            FROM sg_reviews r
            LEFT JOIN sg_products p ON p.id = r.product_id
            WHERE r.is_approved = 0
            ORDER BY r.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Get review statistics
     */
    public static function getStats(?int $productId = null): array
    {
        $pdo = Database::getInstance()->getConnection();
        $where = $productId ? ' WHERE product_id = ' . (int)$productId : '';
        $whereApproved = ($where ? $where . ' AND' : ' WHERE') . ' is_approved = 1';
        $stats = [];
        $stats['total'] = (int)$pdo->query("SELECT COUNT(*) FROM sg_reviews{$where}")->fetchColumn();
        $stats['approved'] = (int)$pdo->query("SELECT COUNT(*) FROM sg_reviews{$whereApproved}")->fetchColumn();
        $stats['pending'] = (int)$pdo->query("SELECT COUNT(*) FROM sg_reviews{$where} AND is_approved = 0")->fetchColumn();
        $avg = (float)$pdo->query("SELECT AVG(rating) FROM sg_reviews{$whereApproved}")->fetchColumn();
        $stats['average_rating'] = $avg;
        $stats['average'] = $avg;

        $distStmt = $pdo->query("SELECT rating, COUNT(*) as count FROM sg_reviews{$whereApproved} GROUP BY rating ORDER BY rating DESC");
        $distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($distStmt->fetchAll() as $row) {
            $distribution[(int)$row['rating']] = (int)$row['count'];
        }
        $stats['distribution'] = $distribution;

        return $stats;
    }

    /**
     * Approve a review
     */
    public static function approve(int $reviewId): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE sg_reviews SET is_approved = 1 WHERE id = :id");
        return $stmt->execute([':id' => $reviewId]);
    }

    /**
     * Reject a review
     */
    public static function reject(int $reviewId): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE sg_reviews SET is_approved = 0 WHERE id = :id");
        return $stmt->execute([':id' => $reviewId]);
    }

    /**
     * Delete a review
     */
    public static function deleteReview(int $reviewId): bool
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM sg_reviews WHERE id = :id");
        return $stmt->execute([':id' => $reviewId]);
    }

    /**
     * Submit a new review
     */
    public static function submit(array $data): array
    {
        $pdo = Database::getInstance()->getConnection();

        $stmt = $pdo->prepare("
            INSERT INTO sg_reviews (product_id, user_id, name, email, rating, title, comment, is_approved, created_at)
            VALUES (:product_id, :user_id, :name, :email, :rating, :title, :comment, 0, NOW())
        ");
        $stmt->execute([
            ':product_id' => $data['product_id'],
            ':user_id' => $data['user_id'] ?? null,
            ':name' => $data['name'],
            ':email' => $data['email'] ?? '',
            ':rating' => (int)$data['rating'],
            ':title' => $data['title'] ?? '',
            ':comment' => $data['comment'],
        ]);

        return [
            'success' => true,
            'id' => (int)$pdo->lastInsertId(),
            'message' => 'Thank you for your review! It will be shown after moderation.'
        ];
    }
}
