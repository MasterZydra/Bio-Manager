<?php

// Start the PHP session

use Framework\Authentication\Session;
use Framework\Facades\Env;

Session::start();

// Register the global available functions
require __DIR__ . '/../framework/registerFn.php';
require __DIR__ . '/../app/registerFn.php';

// Register the available CLI commands
require __DIR__ . '/../app/registerCli.php';
require __DIR__ . '/../framework/registerCli.php';

// Use custom error handler
if (!Env::isCLI()) {
    require __DIR__ . '/../framework/Error/RegisterErrorHandler.php';
}

// Register all available routes
require __DIR__ . '/../app/routes.php';

use Framework\i18n\Translator;
use Framework\Routing\Router;

// Read all label files
Translator::readLabelFiles();

// Route to requested controller or view
if (!Env::isCLI()) {
    Router::run();
}
