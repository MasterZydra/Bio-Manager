<?php

declare(strict_types = 1);

namespace Framework\Test\Commands;

class TestRunCommand extends \Framework\Cli\BaseCommand implements \Framework\Cli\CommandInterface
{
    public function execute(array $args): int
    {
        $testRunner = new \Framework\Test\TestRunner();
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