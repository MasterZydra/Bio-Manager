<?php 

namespace Framework\Database\Migration;

use Framework\Config\Config;
use Framework\Database\Database;
use Framework\Facades\File;
use Framework\Facades\Path;
use RuntimeException;

class MigrationRunner
{
    private string $migrationsPath = '';

    public function __construct()
    {
        $this->migrationsPath = Path::join(__DIR__, '..', '..', '..', 'resources', 'Database', 'Migrations');
    }

    /** Apply all migrations */
    public function run(): void
    {
        $this->runAllMigrations(Path::join(__DIR__, '..', '..', 'resources', 'Database', 'Migrations'));
        $this->runAllMigrations($this->migrationsPath);
    }

    /** Run all the migration */
    private function runAllMigrations(string $migrationsPath): void
    {
        $migrationFiles = $this->getMigrationFiles($migrationsPath);
        sort($migrationFiles);
        foreach ($migrationFiles as $migrationFile) {
            $this->runMigration(Path::join($migrationsPath, $migrationFile));
        }
    }

    /** Get all migration files from the migrations directory */
    private function getMigrationFiles(string $migrationsPath): array
    {
        $allFiles = File::findFilesInDir($migrationsPath, onlyFiles: true);

        $migrationFiles = [];
        /** @var string $file */
        foreach ($allFiles as $file) {
            if (!$this->isMigrationFile($file)) {
                continue;
            }

            array_push($migrationFiles, $file);
        }
        return $migrationFiles;
    }

    private function isMigrationFile(string $filename): bool
    {
        // Migration files cannot start with a dot
        if (str_starts_with($filename, '.')) {
            return false;
        }
        // All migration files must be PHP files
        if (!str_ends_with($filename, '.php')) {
            return false;
        }
        return true;
    }

    /** Run the given migration */
    private function runMigration(string $filepath): void
    {
        if ($this->isMigrationAlreadyApplied($this->extractMigrationName($filepath))) {
            return;
        }

        /** @var MigrationInterface $migration */
        $migration = require $filepath;
        $migration->run();

        $this->addEntryToMigrationTable($filepath);

        printLn('Applied ' . $this->extractMigrationName($filepath));
    }

    /** Checks if the given migration is already applied to the database */
    private function isMigrationAlreadyApplied(string $migrationName): bool
    {
        if (!$this->doesMigrationsTableExists()) {
            return false;
        }

        $result = Database::prepared(
            'SELECT * FROM migrations WHERE `name` = ?',
            's',
            $migrationName
        );

        if ($result === false) {
            return false;
        }

        return $result->numRows() === 1;
    }

    /** Extract the migration name out of the complete file path */
    private function extractMigrationName(string $filepath): string
    {
        $path = explode(DIRECTORY_SEPARATOR, $filepath);
        return str_replace('.php', '', $path[count($path) - 1]);
    }

    /** Insert the given migration file into the migration table */
    private function addEntryToMigrationTable(string $migrationFile): void
    {
        Database::prepared(
            'INSERT INTO migrations (`name`) VALUES (?)',
            's',
            $this->extractMigrationName($migrationFile)
        );
    }

    /** Checks if the table `migrations` is already created */
    private function doesMigrationsTableExists(): bool
    {
        // TODO Find a better solution for this
        $result = false;
        switch (Config::env('DB_CONNECTION')) {
            case 'mariadb':
                $result = Database::prepared(
                    'SELECT TABLE_NAME FROM information_schema.TABLES ' .
                    'WHERE TABLE_SCHEMA LIKE ? AND TABLE_TYPE LIKE \'BASE TABLE\' AND TABLE_NAME = \'migrations\'',
                    's',
                    Database::database()
                );
                break;

            case 'sqlite':
                $result = Database::unprepared('SELECT name FROM sqlite_master WHERE type=\'table\' AND name=\'migrations\'');
                break;
            
            default:
                throw new RuntimeException('The database connection "' . Config::env('DB_CONNECTION') . '" is not supported');
        }
        

        if ($result === false) {
            return false;
        }

        return $result->numRows() === 1;
    }
}
