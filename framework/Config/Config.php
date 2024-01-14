<?php

namespace Framework\Config;

use Framework\Facades\Path;

class Config
{
    private static ?array $env = null;

    public static function env(string $name, mixed $default = null): mixed
    {
        // Check if the requested value is set as system environment variable
        $sysEnv = getenv($name);
        if ($sysEnv !== false) {
            return $sysEnv;
        }

        self::readEnv();

        if (!array_key_exists($name, self::$env)) {
            return $default;
        }

        return self::$env[$name];
    } 

    /** Read env file */
    private static function readEnv(): void
    {
        if (self::$env !== null) {
            return;
        }
        self::$env = ConfigReader::readFile(Path::join(__DIR__, '..', '..', '.env'));
    }
}