<?php

namespace Framework\Database;

use Framework\Config\ConfigReader;
use mysqli_result;

class Database
{
    private static ?array $env = null;

    /** Execute the given query */
    public static function query(string $query): mysqli_result|bool
    {
        self::readEnv();
        $mariaDB = new MariaDB(self::$env['DB_HOST'], intval(self::$env['DB_PORT']), self::$env['DB_DATABASE'], self::$env['DB_USERNAME'], self::$env['DB_PASSWORD']);
        $mariaDB->connect();
        $result = $mariaDB->query($query);
        $mariaDB->disconnect();
        return $result;
    }

    /** Get the database name */
    public static function database(): string
    {
        self::readEnv();
        return self::$env['DB_DATABASE'];
    }

    private static function readEnv(): void
    {
        if (self::$env !== null) {
            return;
        }
        self::$env = ConfigReader::readFile(__DIR__ . '/../../.env');
    }
}