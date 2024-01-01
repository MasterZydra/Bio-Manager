<?php

namespace Framework\Facades;

use Framework\Config\Config;

class Http
{
    /** Redirect the user the the given route */
    public static function redirect(string $route, bool $temporary = true): void
    {
        header(
            'Location: ' . URL::join(Config::env('APP_URL'), $route),
            true,
            $temporary ? 302 : 301
        );
        exit();
    }
}