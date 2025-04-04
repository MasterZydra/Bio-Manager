<?php

declare(strict_types = 1);

namespace Framework\Database\MariaDB;

use Framework\Facades\Convert;

class CreateTableBlueprint implements \Framework\Database\Interface\CreateTableBlueprintInterface
{
    private array $sql = [];

    public function __construct(
        private string $table
    ){
    }

    public function id(): self
    {
        $this->sql[] = 'id INT auto_increment';
        $this->sql[] = 'PRIMARY KEY (id)';
        return $this;
    }

    public function bool(string $column, bool $nullable = false, bool $default = false): self
    {
        $this->sql[] = '`' . $column . '` TINYINT(1) ' . ($nullable ? '' : 'NOT ') . 'NULL DEFAULT ' . Convert::boolToInt($default);
        return $this;
    }

    public function int(string $column, bool $nullable = false, array $foreignKey = []): self
    {
        $this->sql[] = '`' . $column . '` INT ' . ($nullable ? '' : 'NOT ') . 'NULL';
        if (count($foreignKey) === 1) {
            $this->sql[] =
                'CONSTRAINT `fk' . ucfirst($this->table) . ucfirst($column) . '` ' .
                'FOREIGN KEY (' . $column . ') ' .
                'REFERENCES `' . array_keys($foreignKey)[0] . '` (`' . $foreignKey[array_keys($foreignKey)[0]] . '`) ' .
                'ON DELETE CASCADE';
        }
        return $this;
    }

    public function float(string $column, bool $nullable = false): self
    {
        $this->sql[] = '`' . $column . '` FLOAT ' . ($nullable ? '' : 'NOT ') . 'NULL';
        return $this;
    }

    public function string(string $column, int $length, bool $nullable = false, bool $unique = false): self
    {
        $this->sql[] = '`' . $column . '` VARCHAR(' . $length . ') ' . ($nullable ? '' : 'NOT ') . 'NULL';
        if ($unique) {
            $this->sql[] = 'UNIQUE KEY `uk' . ucfirst($this->table) . ucfirst($column) . '` (' . $column . ')';
        }
        return $this;
    }

    public function date(string $column, bool $nullable = false): self
    {
        $this->sql[] = '`' . $column . '` DATE ' . ($nullable ? '' : 'NOT ') . 'NULL';
        return $this;
    }

    public function timestamps(): self
    {
        $this->sql[] = 'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
        $this->sql[] = 'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';
        return $this;
    }

    public function build(): array
    {
        return ['CREATE TABLE `' . $this->table . '` (' . implode(',', $this->sql) . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'];
    }
}