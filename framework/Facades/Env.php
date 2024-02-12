<?php

namespace Framework\Facades;

class Env
{
    public static function isCLI(): bool
    {
        return php_sapi_name() === 'cli';
    }
}