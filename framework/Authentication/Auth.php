<?php

namespace Framework\Authentication;

class Auth
{
    /** Get the id of the logged in user */
    public static function id(): ?int
    {
        if (!array_key_exists('userId', $_SESSION)) {
            return null;
        }
        return $_SESSION['userId'];
    }

    /** Check if the user is logged in */
    public static function isLoggedIn(): bool
    {
        return self::id() !== null;
    }
}