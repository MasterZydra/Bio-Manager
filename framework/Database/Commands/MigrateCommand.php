<?php

namespace Framework\Database\Commands;

use Framework\Cli\BaseCommand;
use Framework\Cli\CommandInterface;
use Framework\Database\Migration\MigrationRunner;

class MigrateCommand extends BaseCommand implements CommandInterface
{
    public function execute(array $args): int
    {
        echo 'Applied migrations:' . PHP_EOL;

        $migrationRunner = new MigrationRunner();
        $migrationRunner->run();
        return 0;
    }

    public function getName(): string
    {
        return 'migrate';
    }

    public function getDescription(): string
    {
        return 'Create a new migration file';
    }
}