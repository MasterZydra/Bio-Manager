<?php

require __DIR__ . '/framework/autoload.php';

require __DIR__ . '/app/registerCli.php';
require __DIR__ . '/framework/registerCli.php';

use \Framework\Cli\Cli;

Cli::run();
