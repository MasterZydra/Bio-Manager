<?php

namespace Framework\Database;

use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;
use Framework\Database\Query\SortOrder;
use Framework\Database\Query\WhereCombine;

class WhereQueryBuilder
{
    private ?QueryBuilder $queryBuilder = null;

    public function __construct(string $table)
    {
        $this->queryBuilder = new QueryBuilder($table);
    }

    public static function new(string $table): self
    {
        return new WhereQueryBuilder($table);
    }

    /** Add a condition to the `WHERE` part */
    public function where(ColType $type, string $column, Condition $condition, mixed $value, WhereCombine $combine = WhereCombine::And): self
    {
        $this->queryBuilder->where($type, $column, $condition, $value, $combine);
        return $this;
    }

    /** Add a column to the `ORDER BY` part */
    public function orderBy(string $column, SortOrder $sortOrder = SortOrder::Asc): self
    {
        $this->queryBuilder->orderBy($column, $sortOrder);
        return $this;
    }

    public function build(): string
    {
        return $this->queryBuilder->build();
    }

    public function isWhereEmpty(): bool
    {
        return $this->queryBuilder->isWhereEmpty();
    }

    public function getValues(): array
    {
        return $this->queryBuilder->getValues();
    }

    public function getColTypes(): string
    {
        return $this->queryBuilder->getColTypes();
    }

    public function hasOrderBySection(): bool
    {
        return $this->queryBuilder->hasOrderBySection();
    }
}