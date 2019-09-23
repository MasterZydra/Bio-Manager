<?php
/*
* Mysql_preparedStatement_BioManger.php
* -------------------------------------
* Class for using prepared statments for a more secure way to
* execute sql queries and prevent sql injections.
* This class has functions which execute the queries for the
* Bio-Manager.
*
* @author David Hein
*
* Changelog:
* ----------
*/
include_once 'modules/Mysql_preparedStatement.php';

class mysql_preparedStatement_BioManager extends mysql_preparedStatement {
    /**
    * Create a new mysql_preparedStatement object.
    * Connect to database.
    */
    function __construct() {
        // Create parent
        parent::__construct();
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
    function getUserPermission($givenUserId, $permission) {
        $sqlQuery = "SELECT $permission FROM ". $this -> conn -> getDatabaseName() . ".T_UserPermission WHERE userId = ?";
        $stmt = $this -> conn -> connectionString -> prepare($sqlQuery);
        $stmt -> bind_param('i', $userId);
        // Query for developer
        $this -> showQuery($sqlQuery);
        // Assign values
        $userId = $givenUserId;
        // Execute query
        if (!$stmt -> execute()) {
            $this -> showError($stmt -> error);
            return NULL;
        } else {
            $row = $this -> getFirstRow($stmt -> get_result());
            // Evalutate data
            if (is_null($row)) {
                return false;
            }
            else {
                return $row[$permission];
            }
            return false;
        }
    }
}

?>