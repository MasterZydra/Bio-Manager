<?php

declare(strict_types = 1);

namespace Framework\Error;

use Exception;
use Framework\Cli\Cli;
use Framework\Facades\DeveloperTools;
use Framework\Facades\Env;
use Framework\Facades\Http;
use Throwable;

class ErrorHandler
{
    public static function handleError(
        int $errno, string $errstr, ?string $errfile = null, ?int $errline = null, ?array $errcontext = null
    ): bool {
        ob_end_clean();
        if (Env::isDev() || DeveloperTools::showErrorMessages()) {
            self::handleDevError($errno, $errstr, $errfile, $errline, $errcontext);
            exit();
        } else {
            self::handleProdError();
            exit();
        }
    }

    public static function handleException(Throwable $exception): void
    {
        ob_end_clean();
        if (Env::isDev() || DeveloperTools::showErrorMessages()) {
            self::handleDevException($exception);
            exit();
        } else {
            self::handleProdException();
            exit();
        }
    }

    private static function handleDevError(
        int $errno, string $errstr, ?string $errfile = null, ?int $errline = null, ?array $errcontext = null
    ): void {
        view(
            'framework.error.dev.uncaughtError',
            [
                'errno' => $errno,
                'errstr' => $errstr,
                'errfile' => $errfile,
                'errline' => $errline,
                'errcontext' => $errcontext,
            ]
        );
    }

    private static function handleDevException(Throwable $exception): void
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
                view('framework.error.dev.uncaughtException', ['exception' => $exception]);
                exit();
            }
        }

        view('framework.error.dev.uncaughtException', ['exception' => $exception]);
    }

    private static function handleProdException(): void
    {
        view('framework.error.prod.uncaughtError');
    }

    private static function handleProdError(): void
    {
        view('framework.error.prod.uncaughtError');
    }
}
