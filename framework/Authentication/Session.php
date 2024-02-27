<?php

namespace Framework\Authentication;

class Session
{
    public static function start(): void
    {
        session_start();
        // Required for Safari and Chrome (Android)
        setcookie('PHPSESSID', session_id());
    }

    public static function getValue(string $key, mixed $default = null): mixed
    {
        if (!array_key_exists($key, $_SESSION)) {
            return $default;
        }

        return $_SESSION[$key];
    }

    public static function setValue(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }
}