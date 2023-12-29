<?php

use Framework\Cli\Cli;
use Framework\Database\Cli\MakeMigrationCommand;
use Framework\Database\Cli\MigrateCommand;
use Framework\Test\Cli\TestRunCommand;

Cli::registerCommand(new MakeMigrationCommand());
Cli::registerCommand(new MigrateCommand());
Cli::registerCommand(new TestRunCommand());
