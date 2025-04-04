<?php

use Framework\Facades\Env;

// Start the PHP session
\Framework\Authentication\Session::start();

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

// Read all label files
\Framework\i18n\Translator::readLabelFiles();

// Route to requested controller or view
if (!Env::isCLI()) {
    \Framework\Routing\Router::run();
}
