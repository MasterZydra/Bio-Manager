<?php

use Framework\Cli\Cli;
use Framework\Cli\Commands\MakeCommandCommand;
use Framework\Database\Commands\MakeMigrationCommand;
use Framework\Database\Commands\MakeModelCommand;
use Framework\Database\Commands\MigrateCommand;
use Framework\Routing\Commands\MakeControllerCommand;
use Framework\Test\Commands\MakeTestCaseCommand;
use Framework\Test\Commands\TestRunCommand;

Cli::registerCommand(new MakeCommandCommand());
Cli::registerCommand(new MakeControllerCommand());
Cli::registerCommand(new MakeMigrationCommand());
Cli::registerCommand(new MakeModelCommand());
Cli::registerCommand(new MakeTestCaseCommand());
Cli::registerCommand(new MigrateCommand());
Cli::registerCommand(new TestRunCommand());
