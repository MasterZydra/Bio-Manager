<?php

// Register the global available functions
require __DIR__ . '/../framework/registerFn.php';
require __DIR__ . '/../app/registerFn.php';

// Register all available routes
require __DIR__ . '/../app/routes.php';

use Framework\i18n\Translator;
use \Framework\Routing\Router;

// Read all label files
Translator::readLabelFiles();

// Route to requested controller or view
Router::run();