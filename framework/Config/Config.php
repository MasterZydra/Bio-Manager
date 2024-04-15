<?php

namespace Framework\Config;

use Framework\Facades\Env;
use Framework\Facades\Path;
use Framework\Test\SupportsTestModeInterface;

class Config implements SupportsTestModeInterface
{
    private static ?array $env = null;

    // Test mode
    private static bool $isTestMode = false;
    private static array $testValues = [];

    public static function env(string $name, mixed $default = null): mixed
    {
        // Test mode
        if (self::$isTestMode) {
            if (!array_key_exists($name, self::$testValues)) {
                return $default;
            }

            return self::$testValues[$name];
        }

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

    // -------------------- Test mode -------------------- 

    public static function useTestMode(): void
    {
        self::$isTestMode = Env::isTestRun();
    }

    public static function setTestValues(string $key, mixed $value): void
    {
        self::$testValues[$key] = $value;
    }
}