<?php
namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Blog extends Model
{
    protected static string $table = 'sg_blogs';
    protected static string $primaryKey = 'id';
    protected static array $fillable = [
        'category_id', 'author_id', 'title', 'slug', 'excerpt', 'content',
        'featured_image', 'meta_title', 'meta_description', 'meta_keywords',
        'is_featured', 'is_published', 'published_at'
    ];

    public static function getAll(bool $publishedOnly = false, int $limit = 20, int $offset = 0): array
    {
        $pdo = Database::getInstance()->getConnection();
        $where = $publishedOnly ? 'WHERE b.is_published = 1' : '';
        $stmt = $pdo->query("SELECT b.*, bc.name AS category_name, bc.slug AS category_slug, u.name AS author_name FROM sg_blogs b LEFT JOIN sg_blog_categories bc ON bc.id = b.category_id LEFT JOIN sg_users u ON u.id = b.author_id $where ORDER BY b.created_at DESC LIMIT $limit OFFSET $offset");
        return $stmt->fetchAll();
    }

    public static function findBySlug(string $slug): ?array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT b.*, bc.name AS category_name, bc.slug AS category_slug, u.name AS author_name FROM sg_blogs b LEFT JOIN sg_blog_categories bc ON bc.id = b.category_id LEFT JOIN sg_users u ON u.id = b.author_id WHERE b.slug = :slug LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        return $stmt->fetch() ?: null;
    }

    public static function resolveCategoryId(string $name): int
    {
        $name = trim($name);
        if ($name === '') return 0;

        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT id FROM sg_blog_categories WHERE name = :n LIMIT 1");
        $stmt->execute([':n' => $name]);
        $row = $stmt->fetch();

        if ($row) return (int)$row['id'];

        $slug = slugify($name);
        $stmt = $pdo->prepare("INSERT INTO sg_blog_categories (name, slug, status) VALUES (:n, :s, 1)");
        $stmt->execute([':n' => $name, ':s' => $slug]);
        return (int)$pdo->lastInsertId();
    }

    public static function getCategoryName(int $id): ?string
    {
        if ($id <= 0) return null;
        try {
            $pdo = Database::getInstance()->getConnection();
            $stmt = $pdo->prepare("SELECT name FROM sg_blog_categories WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch();
            return $row ? $row['name'] : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function createCategory(array $data): int
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO sg_blog_categories (name, slug, description, status, sort_order) VALUES (:n, :s, :d, :st, :so)");
        $stmt->execute([':n' => $data['name'], ':s' => $data['slug'], ':d' => $data['description'] ?? '', ':st' => $data['status'] ?? 1, ':so' => $data['sort_order'] ?? 0]);
        return (int)$pdo->lastInsertId();
    }

    public static function updateCategory(int $id, array $data): void
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE sg_blog_categories SET name = :n, slug = :s, description = :d, status = :st, sort_order = :so WHERE id = :id");
        $stmt->execute([':n' => $data['name'], ':s' => $data['slug'], ':d' => $data['description'] ?? '', ':st' => $data['status'] ?? 1, ':so' => $data['sort_order'] ?? 0, ':id' => $id]);
    }

    public static function deleteCategory(int $id): void
    {
        $pdo = Database::getInstance()->getConnection();
        $pdo->prepare("UPDATE sg_blogs SET category_id = NULL WHERE category_id = :id")->execute([':id' => $id]);
        $pdo->prepare("DELETE FROM sg_blog_categories WHERE id = :id")->execute([':id' => $id]);
    }
}
