<?php

namespace Framework\Test\Commands;

use Framework\Cli\BaseCommand;
use Framework\Cli\CommandInterface;
use Framework\Facades\Path;

class MakeTestCaseCommand extends BaseCommand implements CommandInterface
{
    private string $testFilePath = '';

    public function __construct() {
        $this->testFilePath = Path::join(__DIR__, '..', '..', '..', 'tests');
    }

    public function execute(array $args): int
    {
        $controllerName = $this->input('Unit test case name (e.g. Product):');
        $filename = 'Test' . ucfirst($controllerName) . '.php';
        $path = Path::join($this->testFilePath, 'Unit', $filename);

        file_put_contents(
            $path,
            '<?php' . PHP_EOL . PHP_EOL .
            'use Framework\Test\TestCase;' . PHP_EOL . PHP_EOL .
            'class Test' . ucfirst($controllerName) . ' extends TestCase' . PHP_EOL .
            '{' . PHP_EOL .
            '    public function testFunction(): void' . PHP_EOL .
            '    {' . PHP_EOL .
            '        $this->assertTrue(/* condition */);' . PHP_EOL .
            '        $this->assertEquals(\'expected\', /* code */);' . PHP_EOL .
            '    }' . PHP_EOL .
            '}' . PHP_EOL
        );

        printLn('Created test case "' . $filename . '"');

        return 0;
    }

    public function getName(): string
    {
        return 'make:testcase';
    }

    public function getDescription(): string
    {
        return 'Create a new test case';
    }
}
