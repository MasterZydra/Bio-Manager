<?php

declare(strict_types = 1);

namespace Framework\Database\SQLite;

use Framework\Facades\Convert;

class CreateTableBlueprint implements \Framework\Database\Interface\CreateTableBlueprintInterface
{
    private array $fields = [];
    private array $keys = [];
    private array $afterSql = [];

    public function __construct(
        private string $table
    ){
    }

    public function id(): self
    {
        $this->fields[] = 'id INTEGER PRIMARY KEY';
        return $this;
    }

    public function bool(string $column, bool $nullable = false, bool $default = false): self
    {
        $this->fields[] = '`' . $column . '` TINYINT(1) ' . ($nullable ? '' : 'NOT ') . 'NULL DEFAULT ' . Convert::boolToInt($default);
        return $this;
    }

    public function int(string $column, bool $nullable = false, array $foreignKey = []): self
    {
        $this->fields[] = '`' . $column . '` INTEGER ' . ($nullable ? '' : 'NOT ') . 'NULL';
        if (count($foreignKey) === 1) {
            $this->keys[] =
                'FOREIGN KEY (' . $column . ') ' .
                'REFERENCES `' . array_keys($foreignKey)[0] . '` (`' . $foreignKey[array_keys($foreignKey)[0]] . '`)';
        }
        return $this;
    }

    public function float(string $column, bool $nullable = false): self
    {
        $this->fields[] = '`' . $column . '` REAL ' . ($nullable ? '' : 'NOT ') . 'NULL';
        return $this;
    }

    public function string(string $column, int $length, bool $nullable = false, bool $unique = false): self
    {
        $this->fields[] = '`' . $column . '` VARCHAR(' . $length . ') ' . ($nullable ? '' : 'NOT ') . 'NULL' . ($unique ? ' UNIQUE' : '');
        return $this;
    }

    public function date(string $column, bool $nullable = false): self
    {
        $this->fields[] = '`' . $column . '` DATE ' . ($nullable ? '' : 'NOT ') . 'NULL';
        return $this;
    }

    public function timestamps(): self
    {
        $this->fields[] = 'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
        $this->fields[] = 'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
        // Add "on update" trigger
        $this->afterSql[] = 'CREATE TRIGGER ' . $this->table . '_updateAt AFTER UPDATE ON `' . $this->table . '` BEGIN UPDATE ' . $this->table . ' SET updatedAt=CURRENT_TIMESTAMP WHERE id = NEW.id; END;';
        return $this;
    }

    public function build(): array
    {
        $sql = implode(',', $this->fields);
        $keysSql = implode(',', $this->keys);
        if ($keysSql !== '') {
            $sql .= ',' . $keysSql;
        }
        return [
            'CREATE TABLE `' . $this->table . '` (' . $sql . ');',
            ...$this->afterSql
        ];
    }
}