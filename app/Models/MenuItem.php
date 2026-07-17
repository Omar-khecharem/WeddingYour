<?php
namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class MenuItem extends Model
{
    protected static string $table = 'sg_menu_items';

    public static function getMenuTree(string $location): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            SELECT mi.* FROM sg_menu_items mi
            JOIN sg_menus m ON m.id = mi.menu_id
            WHERE m.location = :location AND m.is_active = 1 AND mi.is_active = 1
            ORDER BY mi.sort_order ASC
        ");
        $stmt->execute([':location' => $location]);
        $items = $stmt->fetchAll();

        $items = self::resolveUrls($pdo, $items);

        return self::buildTree($items);
    }

    private static function resolveUrls(\PDO $pdo, array $items): array
    {
        $categoryIds = [];
        $subcategoryIds = [];
        foreach ($items as $item) {
            if ($item['type'] === 'category' && $item['reference_id']) {
                if ($item['parent_id'] === null) {
                    $categoryIds[] = (int)$item['reference_id'];
                } else {
                    $subcategoryIds[] = (int)$item['reference_id'];
                }
            }
        }

        $categories = [];
        if (!empty($categoryIds)) {
            $ids = implode(',', array_unique($categoryIds));
            $stmt = $pdo->query("SELECT id, slug FROM sg_categories WHERE id IN ($ids)");
            while ($row = $stmt->fetch()) {
                $categories[$row['id']] = $row['slug'];
            }
        }

        $subcategories = [];
        if (!empty($subcategoryIds)) {
            $ids = implode(',', array_unique($subcategoryIds));
            $stmt = $pdo->query("
                SELECT sc.id, sc.slug, sc.category_id, c.slug AS category_slug
                FROM sg_subcategories sc
                JOIN sg_categories c ON c.id = sc.category_id
                WHERE sc.id IN ($ids)
            ");
            while ($row = $stmt->fetch()) {
                $subcategories[$row['id']] = $row;
            }
        }

        foreach ($items as &$item) {
            if ($item['type'] === 'category' && $item['reference_id']) {
                $refId = (int)$item['reference_id'];
                if ($item['parent_id'] === null && isset($categories[$refId])) {
                    $item['url'] = '/category/' . $categories[$refId];
                } elseif ($item['parent_id'] !== null && isset($subcategories[$refId])) {
                    $sc = $subcategories[$refId];
                    $item['url'] = '/products?category=' . $sc['category_slug'] . '&subcategory=' . $sc['slug'];
                }
            }
        }

        return $items;
    }

    private static function buildTree(array $items, int $parentId = null): array
    {
        $tree = [];
        foreach ($items as $item) {
            if ($item['parent_id'] === $parentId) {
                $children = self::buildTree($items, (int)$item['id']);
                if ($children) {
                    $item['children'] = $children;
                }
                $tree[] = $item;
            }
        }
        return $tree;
    }
}
