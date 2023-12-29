<?php 

namespace Framework\Database;

class MigrationRunner
{
    private string $migrationsPath = __DIR__ . '/../../resources/database/migrations';

    /** Apply all migrations */
    public function run(): void
    {
        $this->runAllMigrations(__DIR__ . '/Migrations');
        $this->runAllMigrations($this->migrationsPath);
    }

    /** Run all the migration */
    private function runAllMigrations(string $migrationsPath): void
    {
        $migrationFiles = $this->getMigrationFiles($migrationsPath);
        sort($migrationFiles);
        foreach ($migrationFiles as $migrationFile) {
            $this->runMigration(rtrim($migrationsPath, '/') . '/' . $migrationFile);
        }
    }

    /** Get all migration files from the migrations directory */
    private function getMigrationFiles(string $migrationsPath): array
    {
        $allFiles = scandir($migrationsPath);
        if ($allFiles === false) {
            return [];
        }

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
        $migration->up();

        $this->addEntryToMigrationTable($filepath);

        echo 'Applied ' . $this->extractMigrationName($filepath) . PHP_EOL;
    }

    /** Checks if the given migration is already applied to the database */
    private function isMigrationAlreadyApplied(string $migrationName): bool
    {
        if (!$this->doesMigrationsTableExists()) {
            return false;
        }

        $result = Database::query('SELECT * FROM migrations WHERE `name` = \'' . $migrationName . '\'');

        if ($result === false) {
            return false;
        }

        /** @var \mysqli_result $result */
        return $result->num_rows === 1;
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
        Database::query('INSERT INTO migrations (`name`) VALUES ("' . $this->extractMigrationName($migrationFile) . '")');
    }

    /** Checks if the table `migrations` is already created */
    private function doesMigrationsTableExists(): bool
    {
        $result = Database::query(
            'SELECT TABLE_NAME FROM information_schema.TABLES ' .
            'WHERE TABLE_SCHEMA LIKE \'' . Database::database() . '\' AND TABLE_TYPE LIKE \'BASE TABLE\' AND TABLE_NAME = \'migrations\''
        );

        if ($result === false) {
            return false;
        }

        /** @var \mysqli_result $result */
        return $result->num_rows === 1;
    }
}
