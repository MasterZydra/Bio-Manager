<?php

namespace Framework\Database\SQLite;

use Framework\Database\Interface\BlueprintInterface;
use Framework\Facades\Convert;

class CreateTableBlueprint implements BlueprintInterface
{
    private array $sql = [];
    private array $afterSql = [];

    public function __construct(
        private string $table
    ){
    }

    public function id(): void
    {
        $this->sql[] = 'id INTEGER PRIMARY KEY';
    }

    public function bool(string $column, bool $nullable = false, bool $default = false): void
    {
        $this->sql[] = $column . ' TINYINT(1) ' . ($nullable ? '' : 'NOT ') . 'NULL DEFAULT ' . Convert::boolToInt($default);
    }

    public function int(string $column, bool $nullable = false): void
    {
        $this->sql[] = $column . ' INTEGER ' . ($nullable ? '' : 'NOT ') . 'NULL';
    }

    public function string(string $column, string $length, bool $nullable = false): void
    {
            $this->sql[] = $column . ' VARCHAR(' . $length . ') ' . ($nullable ? '' : 'NOT ') . 'NULL';
    }

    public function timestamps(): void
    {
        $this->sql[] = 'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
        $this->sql[] = 'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
        // Add "on update" trigger
        $this->afterSql[] = 'CREATE TRIGGER ' . $this->table . '_updateAt AFTER UPDATE ON `' . $this->table . '` BEGIN UPDATE ' . $this->table . ' SET updatedAt=CURRENT_TIMESTAMP WHERE id = NEW.id; END;';
    }

    public function build(): array
    {
        return [
            'CREATE TABLE `' . $this->table . '` (' . implode(',', $this->sql) . ');',
            ...$this->afterSql
        ];
    }
}