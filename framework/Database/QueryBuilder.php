<?php

namespace Framework\Database;

class QueryBuilder
{
    private array $columns = [];

    public static function new(): self
    {
        return new QueryBuilder();
    }

    /** Add a condition to the `WHERE` part */
    public function addFilter(ColumnType $type, string $column, Condition $condition, mixed $value): self
    {
        $this->columns[] = ['type' => $type->value, 'column' => $column, 'condition' => $condition->value, 'value' => $value];
        return $this;
    }

    public function isEmpty(): bool
    {
        return count($this->columns) === 0;
    }

    public function getValues(): array
    {
        if ($this->isEmpty()) {
            return [];
        }

        $values = [];
        /** @var array $column */
        foreach ($this->columns as $column) {
            $values[] = $column['value'];
        }

        return $values;
    }

    public function getTypes(): string
    {
        if ($this->isEmpty()) {
            return '';
        }

        $types = '';
        /** @var array $column */
        foreach ($this->columns as $column) {
            $types .= $column['type'];
        }

        return $types;
    }

    public function getWhere(): string
    {
        if ($this->isEmpty()) {
            return '';
        }

        $conditions = [];
        /** @var array $column */
        foreach ($this->columns as $column) {
            $conditions[] = sprintf('`%s` %s ?',
                $column['column'],
                $column['condition']
            );
        }

        return 'WHERE ' . implode(' AND ', $conditions);
    }
}