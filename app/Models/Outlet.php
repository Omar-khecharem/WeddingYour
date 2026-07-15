<?php
namespace App\Models;

use App\Core\Model;

class Outlet extends Model
{
    protected static string $table = 'sg_outlets';
    protected static string $primaryKey = 'id';

    public static function getActive(): array
    {
        $db = self::db();
        $stmt = $db->query("SELECT * FROM sg_outlets WHERE is_active = 1 ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    }

    public static function findBySlug(string $slug): ?array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM sg_outlets WHERE slug = :slug AND is_active = 1 LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        return $stmt->fetch() ?: null;
    }
}
