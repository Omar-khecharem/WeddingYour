<?php
namespace App\Models;

use App\Core\Model;

class Brand extends Model
{
    protected static string $table = 'sg_brands';
    protected static string $primaryKey = 'id';
    protected static array $fillable = ['name', 'slug', 'description', 'logo', 'website', 'meta_title', 'meta_description', 'sort_order', 'featured', 'status'];

    public static function findBySlug(string $slug): ?array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM sg_brands WHERE slug = :s AND status = 1 LIMIT 1");
        $stmt->execute([':s' => $slug]);
        return $stmt->fetch() ?: null;
    }

    public static function getActive(): array
    {
        $db = self::db();
        $stmt = $db->query("SELECT * FROM sg_brands WHERE status = 1 ORDER BY sort_order ASC, name ASC");
        return $stmt->fetchAll();
    }

    public static function getFeatured(): array
    {
        $db = self::db();
        $stmt = $db->query("SELECT * FROM sg_brands WHERE status = 1 AND featured = 1 ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    }
}
