<?php
namespace App\Models;

use App\Core\Model;

class Page extends Model
{
    protected static string $table = 'sg_pages';
    protected static string $primaryKey = 'id';
    protected static array $fillable = ['title', 'slug', 'content', 'meta_title', 'meta_description', 'status', 'sort_order'];

    public static function findBySlug(string $slug): ?array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM sg_pages WHERE slug = :s AND status = 1 LIMIT 1");
        $stmt->execute([':s' => $slug]);
        return $stmt->fetch() ?: null;
    }

    public static function getActive(): array
    {
        $db = self::db();
        $stmt = $db->query("SELECT * FROM sg_pages WHERE status = 1 ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    }
}
