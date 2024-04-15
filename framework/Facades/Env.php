<?php

namespace Framework\Facades;

use Framework\Config\Config;

class Env
{
    public static function isTestRun(): bool
    {
        return key_exists('isTestRun', $GLOBALS);
    }

    public static function isCLI(): bool
    {
        return php_sapi_name() === 'cli';
    }

    public static function isDev(): bool
    {
        return strtolower(Config::env('APP_ENV')) === 'dev';
    }

    public static function isProd(): bool
    {
        return strtolower(Config::env('APP_ENV')) === 'prod';
    }
}