<?php
// https://stackoverflow.com/questions/3228694/php-database-connection-class

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
    $this -> sqlQuery = 'SELECT * FROM '.$this -> databaseName.'.'.$tableName;
    $this -> dataSet = $this -> connectionString -> query($this -> sqlQuery);
    return $this -> dataSet;
}

/*
    $columns: e.g. 'id, name'
    $where: e.g. 'id = 1'
*/
function selectColumsWhere($tableName, $columns, $whereCondition) {
    $this -> sqlQuery =
        'SELECT ' . $columns
        . ' FROM '.$this -> databaseName.'.'.$tableName
        . ' WHERE ' . $whereCondition;
    $this -> dataSet = $this -> connectionString -> query($this -> sqlQuery);
    return $this -> dataSet;
}
    
function selectWhere($tableName,$rowName,$operator,$value,$valueType) {
    $this -> sqlQuery = 'SELECT * FROM '.$tableName.' WHERE '.$rowName.' '.$operator.' ';
    if($valueType == 'int') {
        $this -> sqlQuery .= $value;
    }
    else if($valueType == 'char')   {
        $this -> sqlQuery .= "'".$value."'";
    }
    #echo $this -> sqlQuery;
    $this -> dataSet = $this -> connectionString -> query($this -> sqlQuery);
    $this -> sqlQuery = NULL;
    return $this -> dataSet;
    #return $this -> sqlQuery;
}
    
/*
    $orderByCommand: 'id desc'
*/
function selectOrderBy($tableName, $orderByCommand) {
    $this -> sqlQuery = 'SELECT * FROM '.$tableName.' ORDER BY ' . $orderByCommand;
    $this -> dataSet = $this -> connectionString -> query($this -> sqlQuery);
    #echo $this -> sqlQuery;
    return $this -> dataSet;
}

function insertInto($tableName,$values) {
    $i = NULL;

    $this -> sqlQuery = 'INSERT INTO '.$tableName.' VALUES (';
    $i = 0;
    while(count($values) > $i && $values[$i]["val"] != NULL && $values[$i]["type"] != NULL) {
        if($values[$i]["type"] == "char")   {
            $this -> sqlQuery .= "'";
            $this -> sqlQuery .= $values[$i]["val"];
            $this -> sqlQuery .= "'";
        }
        else if($values[$i]["type"] == 'int')   {
            $this -> sqlQuery .= $values[$i]["val"];
        }
        else if($values[$i]["type"] == 'null')   {
            $this -> sqlQuery .= 'NULL';
        }
        $i++;
        if(count($values) > $i && $values[$i]["val"] != NULL)  {
            $this -> sqlQuery .= ',';
        }
    }
    $this -> sqlQuery .= ')';
    #echo $this -> sqlQuery;
    $this -> connectionString -> query($this -> sqlQuery);
    return $this -> sqlQuery;
    #$this -> sqlQuery = NULL;
}

function selectFreeRun($query)  {
    #echo $query;
    $this -> dataSet = $this -> connectionString -> query($query);
    return $this -> dataSet;
}

function freeRun($query) {
    return $this -> connectionString -> query($query);
  }
}
?>