<?php

namespace Framework\Database;

use Framework\Config\Config;
use Framework\Database\Interface\BlueprintInterface;
use Framework\Database\Interface\CreateTableBlueprintInterface;
use Framework\Database\MariaDB\CreateTableBlueprint as MariaDBCreateTableBlueprint;
use Framework\Database\SQLite\CreateTableBlueprint as SQLiteCreateTableBlueprint;
use RuntimeException;

/** Create SQL statements for generating tables in MySQL/MariaDB and SQLite */
class CreateTableBlueprint implements BlueprintInterface
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

    public function id(): void
    {
        $this->blueprint->id();
    }

    public function bool(string $column, bool $nullable = false, bool $default = false): void
    {
        $this->blueprint->bool($column, $nullable, $default);
    }

    public function int(string $column, bool $nullable = false): void
    {
        $this->blueprint->int($column, $nullable);
    }

    public function string(string $column, string $length, bool $nullable = false): void
    {
        $this->blueprint->string($column, $length, $nullable);
    }

    public function timestamps(): void
    {
        $this->blueprint->timestamps();
    }

    public function build(): array
    {
        return $this->blueprint->build();
    }
}