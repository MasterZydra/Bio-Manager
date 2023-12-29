<?php

namespace Framework\Database\Cli;

use Framework\Cli\BaseCommand;
use Framework\Cli\CommandInterface;

class MakeMigrationCommand extends BaseCommand implements CommandInterface
{
    private string $migrationsPath = __DIR__ . '/../../../resources/database/migrations';

    public function execute(array $args): int
    {
        $migrationName = $this->input('Migration name:');
        $filename = date('Y_m_d_his') . '_' . $migrationName . '.php';
        $path = rtrim($this->migrationsPath, '/') . '/' . $filename;

        file_put_contents(
            $path,
            '<?php' . PHP_EOL . PHP_EOL .
            'use Framework\Database\Database;' . PHP_EOL .
            'use Framework\Database\Migration;' . PHP_EOL . PHP_EOL .
            'return new class extends Migration' . PHP_EOL .
            '{' . PHP_EOL .
            '    public function up(): void' . PHP_EOL .
            '    {' . PHP_EOL .
            '        Database::query(\'CREATE TABLE ...\');' . PHP_EOL .
            '    }' . PHP_EOL .
            '};' . PHP_EOL
        );

        $this->printLn('Created migration "' . $filename . '"');

        return 0;
    }

    public function getName(): string
    {
        return 'make:migration';
    }

    public function getDescription(): string
    {
        return 'Create a new empty migration file';
    }
}