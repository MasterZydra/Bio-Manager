<?php

namespace Framework\Database\MariaDB;

use Framework\Database\Interface\BlueprintInterface;
use Framework\Facades\Convert;

class CreateTableBlueprint implements BlueprintInterface
{
    private array $sql = [];

    public function __construct(
        private string $table
    ){
    }

    public function id(): void
    {
        $this->sql[] = 'id INT auto_increment';
        $this->sql[] = 'PRIMARY KEY (id)';
    }

    public function bool(string $column, bool $nullable = false, bool $default = false): void
    {
        $this->sql[] = $column . ' TINYINT(1) ' . ($nullable ? '' : 'NOT ') . 'NULL DEFAULT ' . Convert::boolToInt($default);
    }

    public function int(string $column, bool $nullable = false): void
    {
        $this->sql[] = $column . ' INT ' . ($nullable ? '' : 'NOT ') . 'NULL';
    }

    public function string(string $column, string $length, bool $nullable = false): void
    {
        $this->sql[] = $column . ' VARCHAR(' . $length . ') ' . ($nullable ? '' : 'NOT ') . 'NULL';
    }

    public function timestamps(): void
    {
        $this->sql[] = 'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
        $this->sql[] = 'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';
    }

    public function build(): array
    {
        return ['CREATE TABLE `' . $this->table . '` (' . implode(',', $this->sql) . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'];
    }
}