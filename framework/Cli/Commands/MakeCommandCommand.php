<?php

declare(strict_types = 1);

namespace Framework\Cli\Commands;

use Framework\Cli\BaseCommand;
use Framework\Cli\CommandInterface;
use Framework\Facades\Path;

class MakeCommandCommand extends BaseCommand implements CommandInterface
{
    private string $commandsPath = '';

    public function __construct() {
        $this->commandsPath = Path::join(__DIR__, '..', '..', '..', 'app', 'Commands');
    }

    public function execute(array $args): int
    {
        $commandName = $this->input('Command name (e.g. cron:run):');
        $commandClassName = $this->input('Command class name (e.g. CronRun):');
        $commandDescription = $this->input('Command description (e.g. Run the cron jobs):');
        $filename = $commandClassName . 'Command.php';
        $path = Path::join($this->commandsPath, $filename);

        file_put_contents(
            $path,
            '<?php' . PHP_EOL . PHP_EOL .
            'use Framework\Cli\BaseCommand;' . PHP_EOL .
            'use Framework\Cli\CommandInterface;' . PHP_EOL . PHP_EOL .
            'class ' . $commandClassName . 'Command extends BaseCommand implements CommandInterface' . PHP_EOL .
            '{' . PHP_EOL .
            '    public function execute(array $args): int' . PHP_EOL .
            '    {' . PHP_EOL .
            '        // Code' . PHP_EOL .
            '        // TODO Register the command in "app/registerCli.php"' . PHP_EOL .
            '        return 0;' . PHP_EOL .
            '    }' . PHP_EOL . PHP_EOL .
            '    public function getName(): string' . PHP_EOL .
            '    {' . PHP_EOL .
            '        return \'' . $commandName . '\';' . PHP_EOL .
            '    }' . PHP_EOL . PHP_EOL .
            '    public function getDescription(): string' . PHP_EOL .
            '    {' . PHP_EOL .
            '        return \'' . $commandDescription . '\';' . PHP_EOL .
            '    }' . PHP_EOL .
            '};' . PHP_EOL
        );

        printLn('Created command "' . $filename . '"');

        return 0;
    }

    public function getName(): string
    {
        return 'make:command';
    }

    public function getDescription(): string
    {
        return 'Create a new command';
    }
}