<?php

namespace Framework\Database;

use Framework\Config\Config;
use Framework\Config\ConfigReader;
use mysqli_result;

class Database
{
    private static ?MariaDB $mariaDB = null;

    /** Execute the given query */
    public static function query(string $query): mysqli_result|bool
    {
        self::getMariaDb();
        self::$mariaDB->connect();
        $result = self::$mariaDB->query($query);
        self::$mariaDB->disconnect();
        return $result;
    }

    /** Execute the given prepared statement */
    public static function prepared(string $query, string $colTypes, ...$values): mysqli_result|bool
    {
        self::getMariaDb();
        self::$mariaDB->connect();
        $result = self::$mariaDB->prepared($query, $colTypes, ...$values);
        self::$mariaDB->disconnect();
        return $result;
    }

    /** Get the database name */
    public static function database(): string
    {
        return Config::env('DB_DATABASE');
    }

    private static function getMariaDb(): void
    {
        if (self::$mariaDB !== null) {
            return;
        }
        self::$mariaDB = new MariaDB(Config::env('DB_HOST'), intval(Config::env('DB_PORT')), Config::env('DB_DATABASE'), Config::env('DB_USERNAME'), Config::env('DB_PASSWORD'));
    }
}