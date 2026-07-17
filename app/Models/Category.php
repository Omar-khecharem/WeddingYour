<?php
/**
 * Category Model
 * 
 * Represents a product category with hierarchical support
 * (parent/child), product counts, and slug-based lookups.
 *
 * @package App\Models
 */

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Category extends Model
{
    protected static string $table = 'categories';
    protected static array $fillable = [
        'parent_id', 'name', 'slug', 'description', 'image',
        'icon', 'meta_title', 'meta_description', 'sort_order', 'status'
    ];

    /**
     * Find by slug
     */
    public static function findBySlug(string $slug): ?array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM sg_categories WHERE slug = :slug AND status = 1 LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        $category = $stmt->fetch();
        return $category ?: null;
    }

    /**
     * Get active categories
     */
    public static function getActive(): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM sg_categories WHERE status = 1 ORDER BY sort_order ASC, name ASC");
        return $stmt->fetchAll();
    }

    /**
     * Get active categories with product count
     */
    public static function getActiveWithProductCount(): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("
            SELECT c.*, COUNT(p.id) as product_count
            FROM sg_categories c
            LEFT JOIN sg_products p ON p.category_id = c.id AND p.status = 1
            WHERE c.status = 1
            GROUP BY c.id
            ORDER BY c.sort_order ASC, c.name ASC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Get parent categories
     */
    public static function getParents(): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM sg_categories WHERE parent_id IS NULL AND status = 1 ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    }

    /**
     * Get child categories
     */
    public static function getChildren(int $parentId): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM sg_categories WHERE parent_id = :pid AND status = 1 ORDER BY sort_order ASC");
        $stmt->execute([':pid' => $parentId]);
        return $stmt->fetchAll();
    }

    /**
     * Get category tree
     */
    public static function getTree(): array
    {
        $parents = self::getParents();
        $tree = [];

        foreach ($parents as $parent) {
            $parent['children'] = self::getChildren($parent['id']);
            $tree[] = $parent;
        }

        return $tree;
    }

    /**
     * Get category breadcrumb path
     */
    public static function getPath(int $categoryId): array
    {
        $path = [];
        $pdo = Database::getInstance()->getConnection();

        $currentId = $categoryId;
        while ($currentId) {
            $stmt = $pdo->prepare("SELECT * FROM sg_categories WHERE id = :id");
            $stmt->execute([':id' => $currentId]);
            $cat = $stmt->fetch();

            if (!$cat) break;

            $path[] = $cat;
            $currentId = $cat['parent_id'];
        }

        return array_reverse($path);
    }

    /**
     * Get category as key-value pairs for dropdowns
     */
    public static function getDropdownList(): array
    {
        $categories = self::getActive();
        $list = [];

        foreach ($categories as $cat) {
            $list[$cat['id']] = $cat['name'];
        }

        return $list;
    }
}
