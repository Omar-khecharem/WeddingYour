<?php
namespace App\Models;

use App\Core\Model;

class Setting extends Model
{
    protected static string $table = 'sg_settings';
    protected static string $primaryKey = 'id';
    protected static array $fillable = ['key', 'value', 'group', 'type'];

    private static array $cache = [];

    public static function get(string $key, mixed $default = null): mixed
    {
        if (isset(self::$cache[$key])) return self::$cache[$key];
        $db = self::db();
        $stmt = $db->prepare("SELECT `value` FROM sg_settings WHERE `key` = :k LIMIT 1");
        $stmt->execute([':k' => $key]);
        $row = $stmt->fetchColumn();
        self::$cache[$key] = $row !== false ? $row : $default;
        return self::$cache[$key];
    }

    public static function set(string $key, string $value, string $group = 'general'): void
    {
        $db = self::db();
        $stmt = $db->prepare("INSERT INTO sg_settings (`key`, `value`, `group`) VALUES (:k, :v, :g) ON DUPLICATE KEY UPDATE `value` = :v2, `group` = :g2");
        $stmt->execute([':k' => $key, ':v' => $value, ':g' => $group, ':v2' => $value, ':g2' => $group]);
        self::$cache[$key] = $value;
    }

    public static function getGroup(string $group): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT `key`, `value` FROM sg_settings WHERE `group` = :g");
        $stmt->execute([':g' => $group]);
        $result = [];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['key']] = $row['value'];
            self::$cache[$row['key']] = $row['value'];
        }
        return $result;
    }

    public static function getAll(): array
    {
        $db = self::db();
        $stmt = $db->query("SELECT `key`, `value`, `group` FROM sg_settings ORDER BY `group`, `key`");
        return $stmt->fetchAll();
    }
}
