<?php

declare(strict_types = 1);

namespace Framework\Facades;

use Framework\Config\Config;

class Http
{
    /** Returns the request method (`GET`, `POST`, etc.) */
    public static function requestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /** Returns the parameter for GET and POST */
    public static function param(string $name, mixed $default = null): mixed
    {
        if (self::requestMethod() === 'GET') {
            if (!array_key_exists($name, $_GET)) {
                return $default;
            }
            return $_GET[$name];
        }

        if (self::requestMethod() === 'POST') {
            if (!array_key_exists($name, $_POST)) {
                return $default;
            }
            return $_POST[$name];
        }

        throw new \Exception(__METHOD__ . ': The method "' . self::requestMethod() . '" is not implemented');
    }

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

    /** Get the request URI (without protocol and host) */
    public static function requestUri()
    {
        return $_SERVER['REQUEST_URI'];    
    }
}