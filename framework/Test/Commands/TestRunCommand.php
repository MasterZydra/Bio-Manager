<?php

namespace Framework\Test\Commands;

use Framework\Cli\BaseCommand;
use Framework\Cli\CommandInterface;
use Framework\Test\TestRunner;

class TestRunCommand extends BaseCommand implements CommandInterface
{
    public function execute(array $args): int
    {
        $testRunner = new TestRunner();
        $testRunner->run();
        return 0;
    }

    public function getName(): string
    {
        return 'test:run';
    }

    public function getDescription(): string
    {
        return 'Run the test cases';
    }
}