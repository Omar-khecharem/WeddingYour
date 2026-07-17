<?php
namespace App\Models;

use App\Core\Model;

class Deal extends Model
{
    protected static string $table = 'sg_deals';
    protected static string $primaryKey = 'id';

    public static function getActive(): array
    {
        $db = self::db();
        $stmt = $db->query("SELECT * FROM sg_deals ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    }
}
