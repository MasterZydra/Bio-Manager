<?php

declare(strict_types = 1);

namespace Framework\Database\Commands;

class MigrateCommand extends \Framework\Cli\BaseCommand implements \Framework\Cli\CommandInterface
{
    public function execute(array $args): int
    {
        echo 'Applied migrations:' . PHP_EOL;

        $migrationRunner = new \Framework\Database\Migration\MigrationRunner();
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