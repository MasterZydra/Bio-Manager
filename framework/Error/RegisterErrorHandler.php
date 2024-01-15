<?php

use Framework\Error\ErrorHandler;

set_error_handler(fn(int $errno, string $errstr, ?string $errfile = null, ?int $errline = null, ?array $errcontext = null) => ErrorHandler::handleError($errno, $errstr, $errfile, $errline, $errcontext));

set_exception_handler(fn(Throwable $exception) => ErrorHandler::handleException($exception));
