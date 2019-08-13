<?php
/*
* DbConfig.php
* ---------
* This file contains the class 'Dbconfig'. The class contains the connection
* data. The data is used by the Mysql class.
* !Important! Keep your login data secret! Do not publish this file with
* valid data!
*
* @Link to original soure code: https://stackoverflow.com/questions/3228694/php-database-connection-class
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

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
