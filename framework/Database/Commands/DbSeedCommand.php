<?php

namespace Framework\Database\Commands;

use Framework\Cli\BaseCommand;
use Framework\Cli\CommandInterface;
use Framework\Database\SeederRunner;

class DbSeedCommand extends BaseCommand implements CommandInterface
{
    public function execute(array $args): int
    {
        echo 'Applied seeders:' . PHP_EOL;

        $seederRunner = new SeederRunner();
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