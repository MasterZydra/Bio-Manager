<?php

namespace Framework\Authentication;

class Session
{
    public static function getValue(string $key, mixed $value = null): mixed
    {
        if (!array_key_exists($key, $_SESSION)) {
            return $value;
        }

        return $_SESSION[$key];
    }

    public static function setValue(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }
}