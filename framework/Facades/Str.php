<?php

namespace Framework\Facades;

/** The String facade provides helper functions for more complex string operations */
class Str
{
    /** Removes all leading spaces on line starts */
    public static function removeLeadingLineSpaces(string $content): string
    {
        return preg_replace('/^ */m', '', $content);
    }
}