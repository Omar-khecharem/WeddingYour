<?php
/**
 * User Model
 * 
 * Represents a user/customer with authentication fields,
 * role-based access control, and profile management.
 *
 * @package App\Models
 */

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class User extends Model
{
    protected static string $table = 'users';
    protected static array $fillable = [
        'name', 'email', 'phone', 'password', 'role',
        'avatar', 'status', 'email_verified_at', 'remember_token'
    ];
    protected static array $guarded = ['id', 'password'];

    /**
     * Find user by email
     */
    public static function findByEmail(string $email): ?array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM sg_users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    /**
     * Get total user count
     */
    public static function getTotalCount(): int
    {
        $pdo = Database::getInstance()->getConnection();
        return (int)$pdo->query("SELECT COUNT(*) FROM sg_users")->fetchColumn();
    }

    /**
     * Get new users this month
     */
    public static function getNewThisMonth(): int
    {
        $pdo = Database::getInstance()->getConnection();
        return (int)$pdo->query("SELECT COUNT(*) FROM sg_users WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")->fetchColumn();
    }

    /**
     * Get users by role
     */
    public static function getByRole(string $role): array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM sg_users WHERE role = :role ORDER BY created_at DESC");
        $stmt->execute([':role' => $role]);
        return $stmt->fetchAll();
    }

    /**
     * Search users
     */
    public static function search(string $query): array
    {
        $pdo = Database::getInstance()->getConnection();
        $search = '%' . $query . '%';
        $stmt = $pdo->prepare("
            SELECT * FROM sg_users 
            WHERE name LIKE :search OR email LIKE :search2 OR phone LIKE :search3
            ORDER BY created_at DESC
            LIMIT 20
        ");
        $stmt->bindValue(':search', $search);
        $stmt->bindValue(':search2', $search);
        $stmt->bindValue(':search3', $search);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
