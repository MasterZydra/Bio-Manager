<?php

declare(strict_types = 1);

use Framework\Error\ErrorHandler;
use Framework\Facades\DeveloperTools;
use Framework\Facades\Env;

set_error_handler(fn(int $errno, string $errstr, ?string $errfile = null, ?int $errline = null, ?array $errcontext = null) => ErrorHandler::handleError($errno, $errstr, $errfile, $errline, $errcontext));

set_exception_handler(fn(Throwable $exception) => ErrorHandler::handleException($exception));

if (Env::isDev() || DeveloperTools::showErrorMessages()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
