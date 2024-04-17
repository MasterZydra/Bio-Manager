<?php

namespace Framework\Database\SQLite;

use Framework\Database\Interface\CreateTableBlueprintInterface;
use Framework\Facades\Convert;

class CreateTableBlueprint implements CreateTableBlueprintInterface
{
    private array $sql = [];
    private array $afterSql = [];

    public function __construct(
        private string $table
    ){
    }

    public function id(): self
    {
        $this->sql[] = 'id INTEGER PRIMARY KEY';
        return $this;
    }

    public function bool(string $column, bool $nullable = false, bool $default = false): self
    {
        $this->sql[] = $column . ' TINYINT(1) ' . ($nullable ? '' : 'NOT ') . 'NULL DEFAULT ' . Convert::boolToInt($default);
        return $this;
    }

    public function int(string $column, bool $nullable = false, array $foreignKey = []): self
    {
        $this->sql[] = $column . ' INTEGER ' . ($nullable ? '' : 'NOT ') . 'NULL';
        if (count($foreignKey) === 1) {
            $this->sql[] =
                'FOREIGN KEY (' . $column . ') ' .
                'REFERENCES `' . array_keys($foreignKey)[0] . '` (`' . $foreignKey[array_keys($foreignKey)[0]] . '`)';
        }
        return $this;
    }

    public function float(string $column, bool $nullable = false): self
    {
        $this->sql[] = $column . ' REAL ' . ($nullable ? '' : 'NOT ') . 'NULL';
        return $this;
    }

    public function string(string $column, string $length, bool $nullable = false, bool $unique = false): self
    {
        $this->sql[] = $column . ' VARCHAR(' . $length . ') ' . ($nullable ? '' : 'NOT ') . 'NULL';
        if ($unique) {
            $this->sql[] = 'UNIQUE(' . $column . ')';
        }
        return $this;
    }

    public function timestamps(): self
    {
        $this->sql[] = 'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
        $this->sql[] = 'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
        // Add "on update" trigger
        $this->afterSql[] = 'CREATE TRIGGER ' . $this->table . '_updateAt AFTER UPDATE ON `' . $this->table . '` BEGIN UPDATE ' . $this->table . ' SET updatedAt=CURRENT_TIMESTAMP WHERE id = NEW.id; END;';
        return $this;
    }

    public function build(): array
    {
        return [
            'CREATE TABLE `' . $this->table . '` (' . implode(',', $this->sql) . ');',
            ...$this->afterSql
        ];
    }
}