<?php
namespace App\Models;

use App\Core\Model;

class GalleryItem extends Model
{
    protected static string $table = 'sg_gallery';
    protected static string $primaryKey = 'id';

    public static function getActive(?int $categoryId = null, int $limit = 20): array
    {
        $db = self::db();
        if ($categoryId) {
            $stmt = $db->prepare("SELECT * FROM sg_gallery WHERE status = 1 AND category_id = :cid ORDER BY sort_order ASC, created_at DESC LIMIT :lim");
            $stmt->bindValue(':cid', $categoryId, \PDO::PARAM_INT);
        } else {
            $stmt = $db->prepare("SELECT * FROM sg_gallery WHERE status = 1 ORDER BY sort_order ASC, created_at DESC LIMIT :lim");
        }
        $stmt->bindValue(':lim', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
