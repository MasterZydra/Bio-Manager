<?php

declare(strict_types = 1);

namespace Framework\Cli;

use Framework\Facades\Env;

/**
 * CLI is the main class for the bioman CLI.
 * The available commands are registered in the `registerCli.php`.
 */
class Cli
{
    private static array $commands = [];

    /** Do all checks and possibly execute the called command */
    public static function run(): void
    {
        // Check that this class is only executed in the CLI context
        if (!Env::isCLI()) {
            echo "This is a CLI command and can only be run in the terminal context.\n";
            exit(1);
        }

        // Not command were given, so show the list of a available commands
        if (count($_SERVER['argv']) < 2) {
            self::listAllCommands();
            exit(0);
        }

        // The given command does not exist, so show the list of available commands
        if (!array_key_exists($_SERVER['argv'][1], self::$commands)) {
            self::listAllCommands();
            exit(0);
        }

        // Call the command execute function
        /** @var CommandInterface $command */
        $command = self::$commands[$_SERVER['argv'][1]];
        exit($command->execute(array_slice($_SERVER['argv'], 2)));
    }

    /** Do all checks and possibly execute the called command for the web CLI */
    public static function runWebCli(string $command, bool $withExit = true): void {
        $command = trim($command);
        $commandParts = explode(' ', $command);

        // Not command were given, so show the list of a available commands
        if (count($commandParts) === 0 || $commandParts[0] === '') {
            self::listAllCommands();
            return;
        }

        // The given command does not exist, so show the list of available commands
        if (!array_key_exists($commandParts[0], self::$commands)) {
            self::listAllCommands();
            return;
        }
        
        // Call the command execute function
        /** @var CommandInterface $command */
        $command = self::$commands[$commandParts[0]];
        $statusCode = $command->execute(array_slice($commandParts, 1));
        if ($withExit) {
            exit($statusCode);
        }
    }

    /** Register a command to make it available in the bioman CLI */
    public static function registerCommand(CommandInterface $command): void
    {
        self::$commands[$command->getName()] = $command;
    }

    /** Generates and prints all commands with their descriptions */
    private static function listAllCommands(): void
    {
        $commandNames = array_keys(self::$commands);
        sort($commandNames);

        printLn('Available commands');
        /** @var string $commandName */
        foreach ($commandNames as $commandName) {
            /** @var CommandInterface $command */
            $command = self::$commands[$commandName];
            printLn(str_pad($command->getName(), 20) . ' ' . $command->getDescription());
        }
    }
}
