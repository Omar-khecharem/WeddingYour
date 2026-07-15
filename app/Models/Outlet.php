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
}
