<?php
namespace App\Models;

use App\Core\Model;

class Address extends Model
{
    protected static string $table = 'sg_addresses';
    protected static string $primaryKey = 'id';
    protected static array $fillable = [
        'user_id', 'customer_id', 'type', 'label', 'full_name', 'phone',
        'address_line1', 'address_line2', 'city', 'state', 'postal_code',
        'country_id', 'is_default'
    ];

    public static function getUserAddresses(int $userId): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT a.*, c.name AS country_name FROM sg_addresses a LEFT JOIN countries c ON a.country_id = c.id WHERE a.user_id = :uid ORDER BY a.is_default DESC, a.created_at DESC");
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll();
    }

    public static function getDefault(int $userId, string $type = 'shipping'): ?array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM sg_addresses WHERE user_id = :uid AND (type = :typ OR type = 'both') AND is_default = 1 LIMIT 1");
        $stmt->execute([':uid' => $userId, ':typ' => $type]);
        $addr = $stmt->fetch();
        if ($addr) return $addr;
        $stmt = $db->prepare("SELECT * FROM sg_addresses WHERE user_id = :uid AND (type = :typ OR type = 'both') ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([':uid' => $userId, ':typ' => $type]);
        return $stmt->fetch() ?: null;
    }

    public static function setDefault(int $addressId, int $userId): void
    {
        $db = self::db();
        $db->prepare("UPDATE sg_addresses SET is_default = 0 WHERE user_id = :uid")->execute([':uid' => $userId]);
        $db->prepare("UPDATE sg_addresses SET is_default = 1 WHERE id = :id AND user_id = :uid")->execute([':id' => $addressId, ':uid' => $userId]);
    }
}
