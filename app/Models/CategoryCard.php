<?php
namespace App\Models;

use App\Core\Model;

class CategoryCard extends Model
{
    protected static string $table = 'sg_category_cards';
    protected static string $primaryKey = 'id';

    public static function getActiveBySection(string $sectionKey): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM sg_category_cards WHERE is_active = 1 AND section_key = :sk ORDER BY sort_order ASC");
        $stmt->execute([':sk' => $sectionKey]);
        return $stmt->fetchAll();
    }

    public static function getActive(): array
    {
        $db = self::db();
        $stmt = $db->query("SELECT * FROM sg_category_cards WHERE is_active = 1 ORDER BY section_key, sort_order ASC");
        return $stmt->fetchAll();
    }
}
