<?php
/*
* Mysql.php
* ---------
* This file contains the class 'Mysql'. It simplifies the connection
* to the SQL server and executing queries. The connection settings
* are stored in 'config/DbConfig.php'.
*
* @Link to original soure code: https://stackoverflow.com/questions/3228694/php-database-connection-class
*
* @Author: David Hein
* 
* Changelog:
* ----------
* 12.08.2019:
*   - Extending freeRun() with developer output and change
*     implementation of other functions to use freeRun().
*/

include 'config/DbConfig.php';

class Mysql extends Dbconfig {

public $connectionString;
public $dataSet;
private $sqlQuery;

protected $databaseName;
protected $hostName;
protected $userName;
protected $passCode;

function __construct() {
    $this -> connectionString = NULL;
    $this -> sqlQuery = NULL;
    $this -> dataSet = NULL;

    $dbPara = new Dbconfig();
    $this -> databaseName = $dbPara -> dbName;
    $this -> hostName = $dbPara -> serverName;
    $this -> userName = $dbPara -> userName;
    $this -> passCode = $dbPara ->passCode;
    $dbPara = NULL;
}

function dbConnect() {
    $this -> connectionString = new mysqli($this -> serverName,$this -> userName,$this -> passCode);
    mysqli_select_db($this -> connectionString, $this -> databaseName);
    return $this -> connectionString;
}

function dbDisconnect() {
    $this -> connectionString = NULL;
    $this -> sqlQuery = NULL;
    $this -> dataSet = NULL;
    $this -> databaseName = NULL;
    $this -> hostName = NULL;
    $this -> userName = NULL;
    $this -> passCode = NULL;
}

function selectAll($tableName) {
    $query = 'SELECT * FROM '.$this -> databaseName.'.'.$tableName;
    return $this -> freeRun($query);
}

/*
    $columns: e.g. 'id, name'
    $where: e.g. 'id = 1'
*/
function selectColumsWhere($tableName, $columns, $whereCondition) {
    $query =
        'SELECT ' . $columns
        . ' FROM '.$this -> databaseName.'.'.$tableName
        . ' WHERE ' . $whereCondition;
    return $this -> freeRun($query);
}
    
function selectWhere($tableName,$rowName,$operator,$value,$valueType) {
    $query = 'SELECT * FROM '.$tableName.' WHERE '.$rowName.' '.$operator.' ';
    if($valueType == 'int') {
        $query .= $value;
    }
    else if($valueType == 'char')   {
        $query .= "'".$value."'";
    }
    return $this -> freeRun($query);
}
    
/*
    $orderByCommand: 'id desc'
*/
function selectOrderBy($tableName, $orderByCommand) {
    $query = 'SELECT * FROM '.$tableName.' ORDER BY ' . $orderByCommand;
    return $this -> freeRun($query);
}

function insertInto($tableName,$values) {
    $i = NULL;

    $query = 'INSERT INTO '.$tableName.' VALUES (';
    $i = 0;
    while(count($values) > $i && $values[$i]["val"] != NULL && $values[$i]["type"] != NULL) {
        if($values[$i]["type"] == "char")   {
            $query .= "'";
            $query .= $values[$i]["val"];
            $query .= "'";
        }
        else if($values[$i]["type"] == 'int')   {
            $query .= $values[$i]["val"];
        }
        else if($values[$i]["type"] == 'null')   {
            $query .= 'NULL';
        }
        $i++;
        if(count($values) > $i && $values[$i]["val"] != NULL)  {
            $query .= ',';
        }
    }
    $query .= ')';
    return $this -> freeRun($query);
}

function getFirstRow() {
    $dataSet = $this -> dataSet;
    if ($dataSet -> num_rows == 0) {
        return NULL;
    } else {
        return $dataSet -> fetch_assoc();
    }
}

function freeRun($query) {
    // Save query
    $this -> sqlQuery = $query;
    // Execute query
    $this -> dataSet = $this -> connectionString -> query($this -> sqlQuery);
    // Developer output
    if(isset($_SESSION['devOpt_ShowQuery']) && $_SESSION['devOpt_ShowQuery']) {
        // Print sql query
        echo '<div class="log">';
        echo '<strong>SQL Query</strong>: ' . $this -> sqlQuery;
        echo '</div>';
        // Show error if something went wrong
        if(!($this -> dataSet)) {
            echo '<div class="warning">';
            echo '<strong>SQL Query failed</strong>: ' . $this -> connectionString -> error;
            echo '</div>';
        }
    }
    // Return result
    return $this -> dataSet;
  }
}
?>