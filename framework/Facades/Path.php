<?php

namespace Framework\Facades;

/** The Path facade provides helper functions for working with paths */
class Path
{
    /** Join the given path parts into one path */
    public static function join($path, ...$paths): string
    {
        $parts = [rtrim($path, '\\/')];
        foreach ($paths as $subpath) {
            array_push($parts, trim($subpath, '\\/'));
        }
        return implode(DIRECTORY_SEPARATOR, $parts);
    }
}