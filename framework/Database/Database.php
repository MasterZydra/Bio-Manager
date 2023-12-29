<?php

namespace Framework\Database;

use Framework\Config\Config;
use Framework\Config\ConfigReader;
use mysqli_result;

class Database
{
    /** Execute the given query */
    public static function query(string $query): mysqli_result|bool
    {
        $mariaDB = new MariaDB(Config::env('DB_HOST'), intval(Config::env('DB_PORT')), Config::env('DB_DATABASE'), Config::env('DB_USERNAME'), Config::env('DB_PASSWORD'));
        $mariaDB->connect();
        $result = $mariaDB->query($query);
        $mariaDB->disconnect();
        return $result;
    }

    /** Get the database name */
    public static function database(): string
    {
        return Config::env('DB_DATABASE');
    }
}