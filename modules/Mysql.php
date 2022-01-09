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
*/

// Check if file exists to prevent warnings
if (file_exists('config/DatabaseConfig.php')) {
    include_once 'config/DatabaseConfig.php';
}

class Mysql
{
    // Public properties
    public $connectionString;
    public $dataSet;
    // Private properties
    private $sqlQuery;
    // Protected properties
    protected $databaseName;
    protected $hostName;
    protected $userName;
    protected $passCode;

    public function __construct()
    {
        $this -> connectionString = null;
        $this -> sqlQuery = null;
        $this -> dataSet = null;

        global $database;
        $this -> databaseName = $database["database_name"];
        $this -> hostName = $database["server_name"];
        $this -> userName = $database["database_username"];
        $this -> passCode = $database["database_password"];
    }

    public function dbConnect()
    {
        $this -> connectionString = new mysqli($this -> hostName, $this -> userName, $this -> passCode);
        mysqli_select_db($this -> connectionString, $this -> databaseName);
        return $this -> connectionString;
    }

    public function dbDisconnect()
    {
        mysqli_close($this -> connectionString);
        $this -> connectionString = null;
        $this -> sqlQuery = null;
        $this -> dataSet = null;
        $this -> databaseName = null;
        $this -> hostName = null;
        $this -> userName = null;
        $this -> passCode = null;
    }

    /**
    * Get database name
    *
    * @author David Hein
    * @return string
    */
    public function getDatabaseName()
    {
        return "`" . $this -> databaseName . "`";
    }

    /**
    * Execute query on database and returns data set
    *
    * @param string    $query  SQL query which will be executed
    *
    * @author David Hein
    * @return data set
    */
    public function freeRun($query)
    {
        // Save query
        $this -> sqlQuery = $query;
        // Execute query
        $this -> dataSet = $this -> connectionString -> query($this -> sqlQuery);
        // Developer output
        if (isset($_SESSION['devOpt_ShowQuery']) && $_SESSION['devOpt_ShowQuery']) {
            // Print sql query
            echo '<div class="log">';
            echo '<strong>SQL Query</strong>: ' . $this -> sqlQuery;
            echo '</div>';
            // Show error if something went wrong
            if (!($this -> dataSet)) {
                echo '<div class="warning">';
                echo '<strong>SQL Query failed</strong>: ' . $this -> connectionString -> error;
                echo '</div>';
            }
        }
        // Return result
        return $this -> dataSet;
    }

    /**
    * Get first row from data set of the last executed query
    *
    * @author David Hein
    * @return data row
    */
    public function getFirstRow()
    {
        $dataSet = $this -> dataSet;
        if ($dataSet -> num_rows == 0) {
            return null;
        } else {
            return $dataSet -> fetch_assoc();
        }
    }

    /**
    * Execute a SELECT statement on connected data base
    *
    * @param string $tableName      Name of the table without database name. E.g. 'T_Supplier'
    * @param string $columns        Columns which will be selected. E.g. 'id, name' or '*'
    * @param string $whereCondition Where condition. If value is NULL, no where condition is added. E.g. 'id = 1'
    * @param string $orderBy        Order by columns. If value is NULL, no order by is added. E.g. 'id DESC, name ASC'
    *
    * @author David Hein
    * @return data set
    */
    public function select($tableName, $columns = '*', $whereCondition = null, $orderBy = null)
    {
        $query =
            'SELECT ' . $columns
            . ' FROM `' . $this -> databaseName . '`.' . $tableName;
        if ($whereCondition !== null) {
            $query .= ' WHERE ' . $whereCondition;
        }
        if ($orderBy !== null) {
            $query .= ' ORDER BY ' . $orderBy;
        }
        return $this -> freeRun($query);
    }

    /**
    * Execute a INSERT statement on connected data base
    *
    * @param string $tableName      Name of the table without database name. E.g. 'T_Supplier'
    * @param string $set            Columns which will be updated and which value is set. E.g. 'isSupplier = 0'
    * @param string $whereCondition Where condition. If value is NULL, no where condition is added. E.g. 'id = 1'
    *
    * @author David Hein
    * @return data set
    */
    public function update($tableName, $set, $whereCondition)
    {
        $query = 'UPDATE `' . $this -> databaseName . '`.' . $tableName . ' '
            . 'SET ' . $set . ' '
            . 'WHERE ' . $whereCondition;
        return $this -> freeRun($query);
    }

    /**
    * Execute a DELETE statement on connected data base
    *
    * @param string $tableName      Name of the table without database name. E.g. 'T_Supplier'
    * @param string $whereCondition Where condition. If value is NULL, no where condition is added. E.g. 'id = 1'
    *
    * @author David Hein
    * @return data set
    */
    public function delete($tableName, $whereCondition)
    {
        $query = 'DELETE FROM `' . $this -> databaseName . '`.' . $tableName . ' '
            . 'WHERE ' . $whereCondition;
        return $this -> freeRun($query);
    }

    public function insertInto($tableName, $values)
    {
        $i = null;

        $query = 'INSERT INTO ' . $tableName . ' VALUES (';
        $i = 0;
        while (count($values) > $i && $values[$i]["val"] != null && $values[$i]["type"] != null) {
            if ($values[$i]["type"] == "char") {
                $query .= "'";
                $query .= $values[$i]["val"];
                $query .= "'";
            } elseif ($values[$i]["type"] == 'int') {
                $query .= $values[$i]["val"];
            } elseif ($values[$i]["type"] == 'null') {
                $query .= 'NULL';
            }
            $i++;
            if (count($values) > $i && $values[$i]["val"] != null) {
                $query .= ',';
            }
        }
        $query .= ')';
        return $this -> freeRun($query);
    }
}
