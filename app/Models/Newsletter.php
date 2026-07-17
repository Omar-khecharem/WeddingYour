<?php
namespace App\Models;

use App\Core\Model;

class Newsletter extends Model
{
    protected static string $table = 'sg_newsletter';
    protected static string $primaryKey = 'id';
    protected static array $fillable = ['email', 'name', 'is_active'];

    public static function subscribe(string $email, ?string $name = null): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT id, is_active FROM sg_newsletter WHERE email = :e LIMIT 1");
        $stmt->execute([':e' => $email]);
        $existing = $stmt->fetch();
        if ($existing) {
            if (!$existing['is_active']) {
                $db->prepare("UPDATE sg_newsletter SET is_active = 1, unsubscribed_at = NULL WHERE id = :id")->execute([':id' => $existing['id']]);
                return ['success' => true, 'message' => 'Réabonnement réussi.'];
            }
            return ['success' => false, 'message' => 'Déjà abonné.'];
        }
        $stmt = $db->prepare("INSERT INTO sg_newsletter (email, name) VALUES (:e, :n)");
        $stmt->execute([':e' => $email, ':n' => $name]);
        return ['success' => true, 'message' => 'Thank you for subscribing!'];
    }

    public static function unsubscribe(string $email): bool
    {
        $db = self::db();
        $stmt = $db->prepare("UPDATE sg_newsletter SET is_active = 0, unsubscribed_at = NOW() WHERE email = :e");
        $stmt->execute([':e' => $email]);
        return $stmt->rowCount() > 0;
    }

    public static function getActive(): array
    {
        $db = self::db();
        $stmt = $db->query("SELECT * FROM sg_newsletter WHERE is_active = 1 ORDER BY subscribed_at DESC");
        return $stmt->fetchAll();
    }

    public static function getCount(): int
    {
        $db = self::db();
        return (int) $db->query("SELECT COUNT(*) FROM sg_newsletter WHERE is_active = 1")->fetchColumn();
    }
}
