<?php
/**
 * Base Model
 * 
 * Abstract base class providing Active Record-style database interaction.
 * All models should extend this class to inherit CRUD operations,
 * query building, and relationship methods.
 *
 * @package App\Core
 */

namespace App\Core;

use PDO;
use PDOStatement;

abstract class Model
{
    /**
     * Database table name
     */
    protected static string $table = '';

    /**
     * Primary key field
     */
    protected static string $primaryKey = 'id';

    /**
     * Allowed fields for mass assignment
     */
    protected static array $fillable = [];

    /**
     * Guarded fields (cannot be mass assigned)
     */
    protected static array $guarded = ['id'];

    /**
     * Fields that are dates/timestamps
     */
    protected static array $dates = ['created_at', 'updated_at'];

    /**
     * Use timestamps (created_at, updated_at)
     */
    protected static bool $timestamps = true;

    /**
     * Soft delete support
     */
    protected static bool $softDelete = false;

    /**
     * Model attributes
     */
    protected array $attributes = [];

    /**
     * Original attributes before modification
     */
    protected array $original = [];

    /**
     * Relationship cache
     */
    protected array $relations = [];

    /**
     * Query builder parts
     */
    protected static array $queryParts = [];

    /**
     * Database connection instance
     */
    protected static ?Database $db = null;

    /**
     * Constructor
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
        $this->original = $this->attributes;
    }

    /**
     * Get database connection
     */
    protected static function db(): Database
    {
        if (self::$db === null) {
            self::$db = Database::getInstance();
        }
        return self::$db;
    }

    /**
     * Get the PDO connection
     */
    protected static function pdo(): PDO
    {
        return self::db()->getConnection();
    }

    /**
     * Get table name
     */
    public static function getTable(): string
    {
        if (static::$table) {
            return DB_PREFIX . static::$table;
        }
        $class = (new \ReflectionClass(static::class))->getShortName();
        return DB_PREFIX . strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $class)) . 's';
    }

    /**
     * Fill model with attributes
     */
    public function fill(array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            if (in_array($key, static::$guarded)) {
                continue;
            }
            if (empty(static::$fillable) || in_array($key, static::$fillable)) {
                $this->attributes[$key] = $value;
            }
        }
    }

    /**
     * Get an attribute
     */
    public function __get(string $key): mixed
    {
        return $this->attributes[$key] ?? $this->relations[$key] ?? null;
    }

    /**
     * Set an attribute
     */
    public function __set(string $key, mixed $value): void
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Check if attribute exists
     */
    public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]) || isset($this->relations[$key]);
    }

    /**
     * Convert model to array
     */
    public function toArray(): array
    {
        return array_merge($this->attributes, $this->relations);
    }

    /**
     * Convert model to JSON
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Find a record by primary key
     */
    public static function find(int|string $id): ?static
    {
        $table = self::getTable();
        $pk = static::$primaryKey;
        $stmt = self::pdo()->prepare("SELECT * FROM {$table} WHERE {$pk} = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new static($data) : null;
    }

    /**
     * Find records by a field value
     */
    public static function findBy(string $field, mixed $value, string $operator = '='): static|array|null
    {
        $table = self::getTable();
        $stmt = self::pdo()->prepare("SELECT * FROM {$table} WHERE {$field} {$operator} :value");
        $stmt->execute([':value' => $value]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) return null;
        if (count($results) === 1) return new static($results[0]);

        return array_map(fn($data) => new static($data), $results);
    }

    /**
     * Get all records
     */
    public static function all(): array
    {
        $table = self::getTable();
        $stmt = self::pdo()->query("SELECT * FROM {$table}");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($data) => new static($data), $results);
    }

    /**
     * Begin a query
     */
    public static function query(): QueryBuilder
    {
        return new QueryBuilder(static::class);
    }

    /**
     * Create a new record
     */
    public static function create(array $data): static
    {
        $model = new static($data);
        $model->save();
        return $model;
    }

    /**
     * Save the model to the database
     */
    public function save(): bool
    {
        $table = self::getTable();
        $pk = static::$primaryKey;

        if (static::$timestamps) {
            $this->attributes['updated_at'] = date('Y-m-d H:i:s');
        }

        if (isset($this->attributes[$pk]) && $this->attributes[$pk]) {
            // Update
            $fields = [];
            $values = [];
            foreach ($this->attributes as $key => $value) {
                if ($key === $pk) continue;
                $fields[] = "{$key} = :{$key}";
                $values[":{$key}"] = $value;
            }
            $values[":{$pk}"] = $this->attributes[$pk];

            $sql = "UPDATE {$table} SET " . implode(', ', $fields) . " WHERE {$pk} = :{$pk}";
            $stmt = self::pdo()->prepare($sql);
            return $stmt->execute($values);
        } else {
            // Insert
            if (static::$timestamps && !isset($this->attributes['created_at'])) {
                $this->attributes['created_at'] = date('Y-m-d H:i:s');
            }

            $fields = array_keys($this->attributes);
            $placeholders = array_map(fn($f) => ":{$f}", $fields);
            $values = [];
            foreach ($this->attributes as $key => $value) {
                $values[":{$key}"] = $value;
            }

            $sql = "INSERT INTO {$table} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
            $stmt = self::pdo()->prepare($sql);
            $result = $stmt->execute($values);

            if ($result) {
                $this->attributes[$pk] = self::pdo()->lastInsertId();
            }
            return $result;
        }
    }

    /**
     * Delete the model
     */
    public function delete(): bool
    {
        if (static::$softDelete) {
            $this->attributes['deleted_at'] = date('Y-m-d H:i:s');
            return $this->save();
        }

        $table = self::getTable();
        $pk = static::$primaryKey;
        $stmt = self::pdo()->prepare("DELETE FROM {$table} WHERE {$pk} = :id");
        return $stmt->execute([':id' => $this->attributes[$pk]]);
    }

    /**
     * Delete multiple records by condition
     */
    public static function deleteWhere(string $field, mixed $value): int
    {
        $table = self::getTable();
        $stmt = self::pdo()->prepare("DELETE FROM {$table} WHERE {$field} = :value");
        $stmt->execute([':value' => $value]);
        return $stmt->rowCount();
    }

    /**
     * Count total records
     */
    public static function count(): int
    {
        $table = self::getTable();
        $stmt = self::pdo()->query("SELECT COUNT(*) FROM {$table}");
        return (int) $stmt->fetchColumn();
    }

    /**
     * Check if a record exists
     */
    public static function exists(string $field, mixed $value): bool
    {
        $table = self::getTable();
        $stmt = self::pdo()->prepare("SELECT COUNT(*) FROM {$table} WHERE {$field} = :value");
        $stmt->execute([':value' => $value]);
        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Paginate results
     */
    public static function paginate(int $page = 1, int $perPage = 12, array $conditions = [], string $orderBy = 'created_at', string $orderDir = 'DESC'): array
    {
        $table = self::getTable();
        $where = '';
        $params = [];

        if (!empty($conditions)) {
            $clauses = [];
            foreach ($conditions as $field => $value) {
                $clauses[] = "{$field} = :cond_{$field}";
                $params[":cond_{$field}"] = $value;
            }
            $where = ' WHERE ' . implode(' AND ', $clauses);
        }

        // Count total
        $countStmt = self::pdo()->prepare("SELECT COUNT(*) FROM {$table}{$where}");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();
        $totalPages = max(1, ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $offset = ($page - 1) * $perPage;

        // Fetch page
        $sql = "SELECT * FROM {$table}{$where} ORDER BY {$orderBy} {$orderDir} LIMIT :limit OFFSET :offset";
        $stmt = self::pdo()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $items = array_map(fn($data) => new static($data), $stmt->fetchAll(PDO::FETCH_ASSOC));

        return [
            'items' => $items,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'hasPrev' => $page > 1,
            'hasNext' => $page < $totalPages,
            'prevPage' => $page - 1,
            'nextPage' => $page + 1,
        ];
    }

    /**
     * Begin a database transaction
     */
    public static function beginTransaction(): bool
    {
        return self::pdo()->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public static function commit(): bool
    {
        return self::pdo()->commit();
    }

    /**
     * Rollback transaction
     */
    public static function rollback(): bool
    {
        return self::pdo()->rollBack();
    }

    /**
     * Get the last inserted ID
     */
    public static function lastInsertId(): string
    {
        return self::pdo()->lastInsertId();
    }

    /**
     * Execute a raw SQL query
     */
    public static function raw(string $sql, array $params = []): PDOStatement|false
    {
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Get dirty (modified) attributes
     */
    public function getDirty(): array
    {
        $dirty = [];
        foreach ($this->attributes as $key => $value) {
            if (!array_key_exists($key, $this->original) || $this->original[$key] !== $value) {
                $dirty[$key] = $value;
            }
        }
        return $dirty;
    }

    /**
     * Reload model from database
     */
    public function fresh(): ?static
    {
        $pk = static::$primaryKey;
        if (!isset($this->attributes[$pk])) return null;
        return static::find($this->attributes[$pk]);
    }
}
