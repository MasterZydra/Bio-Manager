<?php

use Framework\Cli\Cli;
use Framework\Database\Cli\MakeMigrationCommand;
use Framework\Database\Cli\MakeModelCommand;
use Framework\Database\Cli\MigrateCommand;
use Framework\Routing\Cli\MakeControllerCommand;
use Framework\Test\Cli\MakeTestCaseCommand;
use Framework\Test\Cli\TestRunCommand;

Cli::registerCommand(new MakeControllerCommand());
Cli::registerCommand(new MakeMigrationCommand());
Cli::registerCommand(new MakeModelCommand());
Cli::registerCommand(new MakeTestCaseCommand());
Cli::registerCommand(new MigrateCommand());
Cli::registerCommand(new TestRunCommand());
