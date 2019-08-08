<?php
// https://stackoverflow.com/questions/3228694/php-database-connection-class
class Dbconfig {
    protected $serverName;
    protected $userName;
    protected $passCode;
    protected $dbName;

    function __construct() {
        $this -> serverName = 'localhost';
        $this -> userName = 'username';
        $this -> passCode = 'password';
        $this -> dbName = 'dbName';
    }
}
?>
