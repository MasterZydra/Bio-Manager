<?php

namespace Framework\Database;

use Framework\Config\Config;
use Framework\Facades\Convert;
use RuntimeException;

/** Create SQL statements for generating tables in MySQL/MariaDB and SQLite */
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
        switch (Config::env('DB_CONNECTION')) {
            case 'mysql':
                $this->sql[] = 'id INT auto_increment';
                $this->sql[] = 'PRIMARY KEY (id)';
                break;

            case 'sqlite':
                $this->sql[] = 'id INTEGER PRIMARY KEY';
                break;
            
            default:
                throw new RuntimeException('The database connection "' . Config::env('DB_CONNECTION') . '" is not supported');
        }
    }

    public function bool(string $column, bool $nullable = false, bool $default = false): void
    {
        switch (Config::env('DB_CONNECTION')) {
            case 'mysql':
            case 'sqlite':
                $this->sql[] = $column . ' TINYINT(1) ' . ($nullable ? '' : 'NOT ') . 'NULL DEFAULT ' . Convert::boolToInt($default);
                break;
            
            default:
                throw new RuntimeException('The database connection "' . Config::env('DB_CONNECTION') . '" is not supported');
        }
    }

    public function int(string $column, bool $nullable = false): void
    {
        switch (Config::env('DB_CONNECTION')) {
            case 'mysql':
                $this->sql[] = $column . ' INT ' . ($nullable ? '' : 'NOT ') . 'NULL';
                break;

            case 'sqlite':
                $this->sql[] = $column . ' INTEGER ' . ($nullable ? '' : 'NOT ') . 'NULL';
                break;
            
            default:
                throw new RuntimeException('The database connection "' . Config::env('DB_CONNECTION') . '" is not supported');
        }
    }

    public function string(string $column, string $length, bool $nullable = false): void
    {
        switch (Config::env('DB_CONNECTION')) {
            case 'mysql':
            case 'sqlite':
                $this->sql[] = $column . ' VARCHAR(' . $length . ') ' . ($nullable ? '' : 'NOT ') . 'NULL';
                break;
            
            default:
                throw new RuntimeException('The database connection "' . Config::env('DB_CONNECTION') . '" is not supported');
        }
    }

    public function timestamps(): void
    {
        switch (Config::env('DB_CONNECTION')) {
            case 'mysql':
                $this->sql[] = 'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
                $this->sql[] = 'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';
                break;

            case 'sqlite':
                $this->sql[] = 'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
                $this->sql[] = 'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
                // Add "on update" trigger
                $this->afterSql[] = 'CREATE TRIGGER ' . $this->table . '_updateAt AFTER UPDATE ON `' . $this->table . '` BEGIN UPDATE ' . $this->table . ' SET updatedAt=CURRENT_TIMESTAMP WHERE id = NEW.id; END;';
                break;
            
            default:
                throw new RuntimeException('The database connection "' . Config::env('DB_CONNECTION') . '" is not supported');
        }
    }

    public function build(): array
    {
        switch (Config::env('DB_CONNECTION')) {
            case 'mysql':
                return ['CREATE TABLE `' . $this->table . '` (' . implode(',', $this->sql) . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'];

            case 'sqlite':
                return ['CREATE TABLE `' . $this->table . '` (' . implode(',', $this->sql) . ');', ...$this->afterSql];

            default:
                throw new RuntimeException('The database connection "' . Config::env('DB_CONNECTION') . '" is not supported');
        }
    }
}