<?php
namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class ContactMessage extends Model
{
    protected static string $table = 'sg_contact_messages';
    protected static string $primaryKey = 'id';

    public static function getAll(int $page = 1, int $perPage = 20, string $search = '', string $status = ''): array
    {
        $pdo = Database::getInstance()->getConnection();
        $where = [];
        $params = [];

        if ($search) {
            $where[] = '(name LIKE :search OR email LIKE :search OR message LIKE :search)';
            $params[':search'] = '%' . $search . '%';
        }
        if ($status === 'read') {
            $where[] = 'is_read = 1';
        } elseif ($status === 'unread') {
            $where[] = 'is_read = 0';
        }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM sg_contact_messages $whereClause");
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();
        $totalPages = max(1, ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $offset = ($page - 1) * $perPage;

        $stmt = $pdo->prepare("SELECT * FROM sg_contact_messages $whereClause ORDER BY created_at DESC LIMIT :lim OFFSET :off");
        $stmt->bindValue(':lim', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, \PDO::PARAM_INT);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->execute();
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
            'hasPrev' => $page > 1,
            'hasNext' => $page < $totalPages,
            'prevPage' => $page - 1,
            'nextPage' => $page + 1,
        ];
    }

    public static function findById(int $id): ?array
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM sg_contact_messages WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public static function markAsRead(int $id): void
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE sg_contact_messages SET is_read = 1, read_at = NOW() WHERE id = :id AND is_read = 0");
        $stmt->execute([':id' => $id]);
    }

    public static function markAsReplied(int $id): void
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE sg_contact_messages SET is_replied = 1, replied_at = NOW() WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public static function deleteById(int $id): void
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM sg_contact_messages WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public static function getUnreadCount(): int
    {
        $pdo = Database::getInstance()->getConnection();
        return (int)$pdo->query("SELECT COUNT(*) FROM sg_contact_messages WHERE is_read = 0")->fetchColumn();
    }
}
