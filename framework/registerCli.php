<?php

declare(strict_types = 1);

use Framework\Authentication\Commands\MakeUserCommand;
use Framework\Cli\Cli;
use Framework\Cli\Commands\MakeCommandCommand;
use Framework\Database\Commands\DbSeedCommand;
use Framework\Database\Commands\MakeMigrationCommand;
use Framework\Database\Commands\MakeModelCommand;
use Framework\Database\Commands\MakeSeederCommand;
use Framework\Database\Commands\MigrateCommand;
use Framework\Routing\Commands\MakeControllerCommand;
use Framework\Test\Commands\MakeTestCaseCommand;
use Framework\Test\Commands\TestRunCommand;

Cli::registerCommand(new DbSeedCommand());
Cli::registerCommand(new MakeCommandCommand());
Cli::registerCommand(new MakeControllerCommand());
Cli::registerCommand(new MakeMigrationCommand());
Cli::registerCommand(new MakeModelCommand());
Cli::registerCommand(new MakeSeederCommand());
Cli::registerCommand(new MakeTestCaseCommand());
Cli::registerCommand(new MakeUserCommand());
Cli::registerCommand(new MigrateCommand());
Cli::registerCommand(new TestRunCommand());
