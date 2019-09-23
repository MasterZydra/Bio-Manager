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
include 'modules/Mysql_preparedStatement.php';

class mysql_preparedStatement_BioManager extends mysql_preparedStatement {
    /**
    * Create a new mysql_preparedStatement object.
    * Connect to database.
    */
    function __construct() {
        // Create parent
        parent::__construct();
    }

    /**
    * Select supplier with given id
    *
    * @param int    $supplierId Id of supplier whos data will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectSupplier($supplierId) {
        $sqlQuery = "SELECT * FROM T_Supplier WHERE id = ?";
        $stmt = $this -> conn -> connectionString -> prepare($sqlQuery);
        $stmt -> bind_param('i', $id);
        // Query for developer
        $this -> showQuery($sqlQuery);
        // Assign values
        $id = $supplierId;
        // Execute query
        if (!$stmt -> execute()) {
            $this -> showError($stmt -> error);
            return NULL;
        } else {
            return $stmt -> get_result();
        }
    }
}

?>