<?php

namespace Framework\Facades;

class URL
{
    /** Join the given URL parts into one URL */
    public static function join($url, ...$urls): string
    {
        $parts = [rtrim($url, '/')];
        foreach ($urls as $urlpart) {
            array_push($parts, trim($urlpart, '/'));
        }
        return implode('/', $parts);
    }
}