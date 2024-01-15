<?php

namespace Framework\Error;

use Exception;
use Framework\Cli\Cli;
use Framework\Facades\Http;
use Throwable;

class ErrorHandler
{
    public static function handleError(
        int $errno, string $errstr, string $errfile = null, int $errline = null, array $errcontext = null
    ): bool {
        view(
            'framework.error.uncaughtError',
            [
                'errno' => $errno,
                'errstr' => $errstr,
                'errfile' => $errfile,
                'errline' => $errline,
                'errcontext' => $errcontext,
            ]
        );
        exit();
    }

    public static function handleException(Throwable $exception)
    {
        $commandWhiteList = ['migrate'];

        // Execution the command that was triggered from the exception view
        // and check if the command is in the whitelist
        $command = Http::param('runCommand');
        if ($command !== null && is_string($command) && in_array($command, $commandWhiteList)
        ) {
            try {
                Cli::runWebCli($command, false);
                Http::redirect(Http::requestUri());
            } catch (Exception $exception) {
                view('framework.error.uncaughtException', ['exception' => $exception]);
                exit();
            }
        }

        view('framework.error.uncaughtException', ['exception' => $exception]);
        exit();
    }
}
