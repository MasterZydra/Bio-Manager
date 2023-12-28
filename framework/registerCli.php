<?php

use Framework\Cli\Cli;
use Framework\Test\Cli\TestRunCommand;

Cli::registerCommand(new TestRunCommand());