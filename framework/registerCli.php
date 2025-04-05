<?php

declare(strict_types = 1);

use Framework\Cli\Cli;

Cli::registerCommand(new \Framework\Authentication\Commands\MakeUserCommand());
Cli::registerCommand(new \Framework\Cli\Commands\MakeCommandCommand());
Cli::registerCommand(new \Framework\Database\Commands\DbSeedCommand());
Cli::registerCommand(new \Framework\Database\Commands\MakeMigrationCommand());
Cli::registerCommand(new \Framework\Database\Commands\MakeModelCommand());
Cli::registerCommand(new \Framework\Database\Commands\MakeSeederCommand());
Cli::registerCommand(new \Framework\Database\Commands\MigrateCommand());
Cli::registerCommand(new \Framework\Routing\Commands\MakeControllerCommand());
Cli::registerCommand(new \Framework\Test\Commands\MakeTestCaseCommand());
Cli::registerCommand(new \Framework\Test\Commands\TestRunCommand());
