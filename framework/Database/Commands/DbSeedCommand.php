<?php

declare(strict_types = 1);

namespace Framework\Database\Commands;

class DbSeedCommand extends \Framework\Cli\BaseCommand implements \Framework\Cli\CommandInterface
{
    public function execute(array $args): int
    {
        echo 'Applied seeders:' . PHP_EOL;

        $seederRunner = new \Framework\Database\Seeder\SeederRunner();
        $seederRunner->run();
        return 0;
    }

    public function getName(): string
    {
        return 'db:seed';
    }

    public function getDescription(): string
    {
        return 'Run all seeders';
    }
}