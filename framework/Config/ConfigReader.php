<?php

declare(strict_types = 1);

namespace Framework\Config;

/** The ConfigReader is used to read e.g. the `.env` file */
class ConfigReader
{
    /** Read the given file and parse it as ini file */
    public static function readFile(string $filename): array
    {
        return parse_ini_file($filename);
    }
}