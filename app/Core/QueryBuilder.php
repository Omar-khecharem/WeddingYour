<?php
/**
 * Query Builder
 * 
 * Fluent SQL query builder for constructing SELECT, INSERT, UPDATE,
 * and DELETE queries programmatically with parameter binding.
 *
 * @package App\Core
 */

namespace App\Core;

use PDO;

class QueryBuilder
{
    private string $modelClass;
    private string $table;
    private array $select = ['*'];
    private array $where = [];
    private array $params = [];
    private array $joins = [];
    private array $orderBy = [];
    private ?int $limit = null;
    private ?int $offset = null;
    private ?string $groupBy = null;
    private array $having = [];

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
        $this->table = $modelClass::getTable();
    }

    /**
     * Specify select columns
     */
    public function select(array|string $columns): self
    {
        $this->select = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    /**
     * Add a where clause
     */
    public function where(string $column, mixed $value, string $operator = '=', string $boolean = 'AND'): self
    {
        $param = ':where_' . count($this->params);
        $this->where[] = [
            'boolean' => $boolean,
            'column' => $column,
            'operator' => $operator,
            'param' => $param,
            'value' => $value
        ];
        $this->params[$param] = $value;
        return $this;
    }

    /**
     * Add an OR where clause
     */
    public function orWhere(string $column, mixed $value, string $operator = '='): self
    {
        return $this->where($column, $value, $operator, 'OR');
    }

    /**
     * Add a WHERE IN clause
     */
    public function whereIn(string $column, array $values): self
    {
        $params = [];
        foreach ($values as $i => $value) {
            $param = ':where_in_' . count($this->params) . '_' . $i;
            $params[] = $param;
            $this->params[$param] = $value;
        }
        $this->where[] = [
            'boolean' => 'AND',
            'raw' => "{$column} IN (" . implode(', ', $params) . ")"
        ];
        return $this;
    }

    /**
     * Add a WHERE NULL clause
     */
    public function whereNull(string $column): self
    {
        $this->where[] = [
            'boolean' => 'AND',
            'raw' => "{$column} IS NULL"
        ];
        return $this;
    }

    /**
     * Add a WHERE NOT NULL clause
     */
    public function whereNotNull(string $column): self
    {
        $this->where[] = [
            'boolean' => 'AND',
            'raw' => "{$column} IS NOT NULL"
        ];
        return $this;
    }

    /**
     * Add a WHERE LIKE clause
     */
    public function whereLike(string $column, string $pattern): self
    {
        return $this->where($column, $pattern, 'LIKE');
    }

    /**
     * Add a JOIN clause
     */
    public function join(string $table, string $first, string $operator, string $second, string $type = 'INNER'): self
    {
        $this->joins[] = "{$type} JOIN {$table} ON {$first} {$operator} {$second}";
        return $this;
    }

    /**
     * Add a LEFT JOIN clause
     */
    public function leftJoin(string $table, string $first, string $operator, string $second): self
    {
        return $this->join($table, $first, $operator, $second, 'LEFT');
    }

    /**
     * Add a RIGHT JOIN clause
     */
    public function rightJoin(string $table, string $first, string $operator, string $second): self
    {
        return $this->join($table, $first, $operator, $second, 'RIGHT');
    }

    /**
     * Add ORDER BY clause
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy[] = "{$column} {$direction}";
        return $this;
    }

    /**
     * Add GROUP BY clause
     */
    public function groupBy(string $column): self
    {
        $this->groupBy = $column;
        return $this;
    }

    /**
     * Add HAVING clause
     */
    public function having(string $column, mixed $value, string $operator = '='): self
    {
        $param = ':having_' . count($this->params);
        $this->having[] = "{$column} {$operator} {$param}";
        $this->params[$param] = $value;
        return $this;
    }

    /**
     * Set LIMIT
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Set OFFSET
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Set pagination (limit + offset)
     */
    public function paginate(int $page = 1, int $perPage = 12): self
    {
        $this->limit = $perPage;
        $this->offset = ($page - 1) * $perPage;
        return $this;
    }

    /**
     * Build WHERE clause
     */
    private function buildWhere(): string
    {
        if (empty($this->where)) return '';

        $clauses = [];
        foreach ($this->where as $i => $clause) {
            if (isset($clause['raw'])) {
                $clauses[] = ($i === 0 ? '' : $clause['boolean'] . ' ') . $clause['raw'];
            } else {
                $prefix = ($i === 0) ? '' : $clause['boolean'] . ' ';
                $clauses[] = "{$prefix}{$clause['column']} {$clause['operator']} {$clause['param']}";
            }
        }

        return ' WHERE ' . implode(' ', $clauses);
    }

    /**
     * Build the full SELECT query
     */
    private function buildSelect(): string
    {
        $sql = "SELECT " . implode(', ', $this->select) . " FROM {$this->table}";
        $sql .= implode(' ', $this->joins);
        $sql .= $this->buildWhere();

        if ($this->groupBy) {
            $sql .= " GROUP BY {$this->groupBy}";
        }

        if (!empty($this->having)) {
            $sql .= " HAVING " . implode(' AND ', $this->having);
        }

        if (!empty($this->orderBy)) {
            $sql .= " ORDER BY " . implode(', ', $this->orderBy);
        }

        if ($this->limit !== null) {
            $sql .= " LIMIT {$this->limit}";
        }

        if ($this->offset !== null) {
            $sql .= " OFFSET {$this->offset}";
        }

        return $sql;
    }

    /**
     * Execute and fetch all results
     */
    public function get(): array
    {
        $sql = $this->buildSelect();
        $stmt = Database::getInstance()->getConnection()->prepare($sql);
        $stmt->execute($this->params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($data) => new $this->modelClass($data), $rows);
    }

    /**
     * Execute and fetch first result
     */
    public function first(): ?object
    {
        $this->limit(1);
        $results = $this->get();
        return $results[0] ?? null;
    }

    /**
     * Get count
     */
    public function count(): int
    {
        $this->select = ['COUNT(*) as count'];
        $sql = $this->buildSelect();
        $stmt = Database::getInstance()->getConnection()->prepare($sql);
        $stmt->execute($this->params);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Check if any records exist
     */
    public function exists(): bool
    {
        return $this->count() > 0;
    }

    /**
     * Execute delete
     */
    public function delete(): int
    {
        $sql = "DELETE FROM {$this->table}";
        $sql .= $this->buildWhere();
        $stmt = Database::getInstance()->getConnection()->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    /**
     * Execute update
     */
    public function update(array $data): int
    {
        $sets = [];
        $params = $this->params;

        foreach ($data as $column => $value) {
            $param = ':update_' . count($params);
            $sets[] = "{$column} = {$param}";
            $params[$param] = $value;
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets);
        $sql .= $this->buildWhere();

        $stmt = Database::getInstance()->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    /**
     * Dump SQL for debugging
     */
    public function toSql(): string
    {
        return $this->buildSelect();
    }

    /**
     * Get all bound parameters
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
