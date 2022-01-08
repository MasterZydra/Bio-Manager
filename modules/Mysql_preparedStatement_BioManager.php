<?php

/*
* Mysql_preparedStatement_BioManger.php
* -------------------------------------
* Class for using prepared statments for a more secure way to
* execute sql queries and prevent sql injections.
* This class has functions which execute the queries for the
* Bio-Manager.
*
* @Author David Hein
*/
include_once 'modules/Mysql_preparedStatement.php';

class mysql_preparedStatement_BioManager extends mysql_preparedStatement
{
    /**
    * Create a new mysql_preparedStatement object.
    * Connect to database.
    */
    public function __construct()
    {
        // Create parent
        parent::__construct();
    }

    /**
    * Select mysqli_result from an given column, table and userId
    *
    * @param string $col    Column which will be selected
    * @param string $table  Table from where the data will be selected
    * @param int    $givenId    Id of data row which will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectColWhereUserId($col, $table, $givenId)
    {
        return $this -> selectColWhereCol($col, $table, "userId", $givenId);
    }

    /**
    * Delete entry in table with an given table and userId
    *
    * @param string $table  Table from where the data will be deleted
    * @param int    $givenId    Id of data row which will be deleted
    *
    * @author David Hein
    * @return boolean
    */
    public function deleteWhereUserId($table, $givenId)
    {
        return $this -> deleteWhereCol($table, "userId", $givenId);
    }

    /*
    * Get a permission for a given user id.
    *
    * @param int    $givenUserId    User id of the user whose permission is requested
    * @param string $permission Permission name
    *
    * @author David Hein
    * @return boolean/NULL - false if not no data has been found.
    */
    public function getUserPermission($givenUserId, $permission)
    {
        $row = $this -> selectColWhereUserId($permission, "T_UserPermission", $givenUserId);
        // Evalutate data
        if (is_null($row)) {
            return false;
        } else {
            return $row[$permission];
        }
        return false;
    }
}
