<?php

namespace Framework\Database\Commands;

use Framework\Cli\BaseCommand;
use Framework\Cli\CommandInterface;
use Framework\Facades\Path;

class MakeMigrationCommand extends BaseCommand implements CommandInterface
{
    private string $migrationsPath = '';

    public function __construct() {
        $this->migrationsPath = Path::join(__DIR__, '..', '..', '..', 'resources', 'Database', 'Migrations');
    }

    public function execute(array $args): int
    {
        $migrationName = $this->input('Migration name (e.g. create_products_table):');
        $filename = date('Y_m_d_his') . '_' . $migrationName . '.php';
        $path = Path::join($this->migrationsPath, $filename);

        file_put_contents(
            $path,
            '<?php' . PHP_EOL . PHP_EOL .
            'use Framework\Database\CreateTableBlueprint;' . PHP_EOL .
            'use Framework\Database\Database;' . PHP_EOL .
            'use Framework\Database\Migration\Migration;' . PHP_EOL . PHP_EOL .
            'return new class extends Migration' . PHP_EOL .
            '{' . PHP_EOL .
            '    public function run(): void' . PHP_EOL .
            '    {' . PHP_EOL .
            '        Database::executeBlueprint((new CreateTableBlueprint(\'tablename\'))' . PHP_EOL .
            '            ->id()' . PHP_EOL .
            '            ->string(\'column-name\', 255)' . PHP_EOL .
            '            ->timestamps()' . PHP_EOL .
            '        );' . PHP_EOL .
            '    }' . PHP_EOL .
            '};' . PHP_EOL
        );

        printLn('Created migration "' . $filename . '"');

        return 0;
    }

    public function getName(): string
    {
        return 'make:migration';
    }

    public function getDescription(): string
    {
        return 'Create a new migration';
    }
}