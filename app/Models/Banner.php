<?php
namespace App\Models;

use App\Core\Model;

class Banner extends Model
{
    protected static string $table = 'sg_banners';
    protected static string $primaryKey = 'id';

    public static function getActiveByPosition(string $position): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM sg_banners WHERE is_active = 1 AND position = :pos AND (start_at IS NULL OR start_at <= NOW()) AND (end_at IS NULL OR end_at >= NOW()) ORDER BY sort_order ASC");
        $stmt->execute([':pos' => $position]);
        return $stmt->fetchAll();
    }

    public static function getAllActive(): array
    {
        $db = self::db();
        $stmt = $db->query("SELECT * FROM sg_banners WHERE is_active = 1 AND (start_at IS NULL OR start_at <= NOW()) AND (end_at IS NULL OR end_at >= NOW()) ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    }
}
