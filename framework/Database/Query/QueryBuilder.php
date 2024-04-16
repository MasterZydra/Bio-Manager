<?php

namespace Framework\Database\Query;

class QueryBuilder
{
    private array $select = [];
    private string $from = '';
    private array $where = [];
    private array $orderBy = [];

    public function __construct(string $table)
    {
        $this->from = $table;
    }

    public static function new(string $table): self
    {
        return new QueryBuilder($table);
    }

    /** Add a column to the select `SELECT` part */
    public function select(string $column): self
    {
        $this->select[] = $column;
        return $this;
    }

    /** Add a condition to the `WHERE` part */
    public function where(ColType $type, string $column, Condition $condition, mixed $value, WhereCombine $combine = WhereCombine::And): self
    {
        $this->where[] = ['type' => $type->value, 'column' => $column, 'condition' => $condition->value, 'value' => $value, 'combine' => $combine->value];
        return $this;
    }

    /** Add a column to the `ORDER BY` part */
    public function orderBy(string $column, SortOrder $sortOrder = SortOrder::Asc): self
    {
        $this->orderBy[] = ['column' => $column, 'sortOrder' => $sortOrder->value];
        return $this;
    }

    public function build(): string
    {
        // Columns to select
        $selectStr = '*';
        if (count($this->select) !== 0) {
            $selectStr = implode(', ', $this->select);
        }

        $sql = 'SELECT ' . $selectStr . ' FROM `' . $this->from . '` ';

        // WHERE conditions
        $sql .= $this->getWhereStr();

        // ORDER BY
        $sql .= $this->getOrderByStr();

        return trim($sql);
    }

    public function isWhereEmpty(): bool
    {
        return count($this->where) === 0;
    }

    public function getValues(): array
    {
        if ($this->isWhereEmpty()) {
            return [];
        }

        $values = [];
        /** @var array $column */
        foreach ($this->where as $column) {
            if ($column['type'] === 'null') {
                continue;
            }
            if (is_array($column['value'])) {
                foreach ($column['value'] as $value) {
                    $values[] = $value;
                }
            } else {
                $values[] = $column['value'];
            }
        }

        return $values;
    }

    public function getColTypes(): string
    {
        if ($this->isWhereEmpty()) {
            return '';
        }

        $types = '';
        /** @var array $column */
        foreach ($this->where as $column) {
            if ($column['type'] === 'null') {
                continue;
            }
            if (is_array($column['value'])) {
                foreach ($column['value'] as $value) {
                    $types .= $column['type'];
                }
            } else {
                $types .= $column['type'];
            }
        }

        return $types;
    }

    public function hasOrderBySection(): bool
    {
        return $this->getOrderByStr() !== '';
    }

    private function getWhereStr(): string
    {
        if ($this->isWhereEmpty()) {
            return '';
        }

        $isFirst = true;
        $conditions = '';
        /** @var array $column */
        foreach ($this->where as $column) {
            if (!$isFirst) {
                $conditions .= ' ' . $column['combine'] . ' ';
            } 
            if ($isFirst) {
                $isFirst = false;
            }
            $value = $column['type'] === 'null' ? 'NULL' : '?';
            if (is_array($column['value'])) {
                $value = '(' . implode(', ', array_fill(0, count($column['value']), '?')) . ')';
            }
            $conditions .= sprintf('`%s` %s %s',
                $column['column'],
                $column['condition'],
                $value
            );
        }

        return 'WHERE ' . $conditions . ' ';
    }

    private function getOrderByStr(): string
    {
        if (count($this->orderBy) === 0) {
            return '';
        }

        $conditions = [];
        /** @var array $column */
        foreach ($this->orderBy as $column) {
            $conditions[] = sprintf('`%s` %s',
                $column['column'],
                $column['sortOrder']
            );
        }

        return 'ORDER BY ' . implode(', ', $conditions) . ' ';
    }
}