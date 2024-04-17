<?php

namespace Framework\Database;

use Framework\Config\Config;
use Framework\Database\Interface\BlueprintInterface;
use Framework\Database\Interface\CreateTableBlueprintInterface;
use Framework\Database\MariaDB\CreateTableBlueprint as MariaDBCreateTableBlueprint;
use Framework\Database\SQLite\CreateTableBlueprint as SQLiteCreateTableBlueprint;
use RuntimeException;

/** Create SQL statements for generating tables in MySQL/MariaDB and SQLite */
class CreateTableBlueprint implements BlueprintInterface, CreateTableBlueprintInterface
{
    private ?CreateTableBlueprintInterface $blueprint = null;

    public function __construct(
        private string $table
    ){
        switch (Config::env('DB_CONNECTION')) {
            case 'mysql':
                $this->blueprint = new MariaDBCreateTableBlueprint($table);
                break;

            case 'sqlite':
                $this->blueprint = new SQLiteCreateTableBlueprint($table);
                break;
            
            default:
                throw new RuntimeException('The database connection "' . Config::env('DB_CONNECTION') . '" is not supported');
        }
    }

    public function id(): self
    {
        $this->blueprint->id();
        return $this;
    }

    public function bool(string $column, bool $nullable = false, bool $default = false): self
    {
        $this->blueprint->bool($column, $nullable, $default);
        return $this;
    }

    /**
     * @param array $foreignKey `['table name' => 'table column']`
     */
    public function int(string $column, bool $nullable = false, array $foreignKey = []): self
    {
        $this->blueprint->int($column, $nullable, $foreignKey);
        return $this;
    }

    public function string(string $column, string $length, bool $nullable = false, bool $unique = false): self
    {
        $this->blueprint->string($column, $length, $nullable, $unique);
        return $this;
    }

    public function timestamps(): self
    {
        $this->blueprint->timestamps();
        return $this;
    }

    public function build(): array
    {
        return $this->blueprint->build();
    }
}