<?php

namespace Framework\Database\Commands;

use Framework\Cli\BaseCommand;
use Framework\Cli\CommandInterface;
use Framework\Facades\Path;

class MakeSeederCommand extends BaseCommand implements CommandInterface
{
    private string $seedersPath = '';

    public function __construct() {
        $this->seedersPath = Path::join(__DIR__, '..', '..', '..', 'resources', 'Database', 'Seeders');
    }

    public function execute(array $args): int
    {
        $seederName = $this->input('Seeder name (e.g. User):');
        $filename = $seederName . 'Seeder.php';
        $path = Path::join($this->seedersPath, $filename);

        file_put_contents(
            $path,
            '<?php' . PHP_EOL . PHP_EOL .
            'namespace Resources\Database\Seeders;' . PHP_EOL . PHP_EOL .
            'use Framework\Database\Database;' . PHP_EOL .
            'use Framework\Database\Seeder;' . PHP_EOL .
            'use Framework\Database\SeederInterface;' . PHP_EOL . PHP_EOL .
            'class ' . $seederName . 'Seeder extends Seeder implements SeederInterface' . PHP_EOL .
            '{' . PHP_EOL .
            '    public function run(): void' . PHP_EOL .
            '    {' . PHP_EOL .
            '        Database::query(\'INSERT INTO ...\');' . PHP_EOL .
            '    }' . PHP_EOL .
            '};' . PHP_EOL
        );

        printLn('Created seeder "' . $filename . '"');

        return 0;
    }

    public function getName(): string
    {
        return 'make:seeder';
    }

    public function getDescription(): string
    {
        return 'Create a new seeder';
    }
}