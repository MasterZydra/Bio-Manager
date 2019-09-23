<?php
/*
* Mysql_preparedStatement.php
* ---------------------------
* Class for using prepared statments for a more secure way to
* execute sql queries and prevent sql injections.
*
* @author David Hein
*
* Changelog:
* ----------
*/
include_once 'modules/Mysql.php';

class mysql_preparedStatement {
    /**
    * Mysqli object for connection to database
    * @var mysqli
    */
    protected $conn;
    
    /**
    * Create a new mysql_preparedStatement object.
    * Connect to database.
    */
    function __construct() {
        $this -> conn = new Mysql();
        $this -> conn -> dbConnect();
    }
    
    /**
    * Close connection to database
    */
    public function destroy() {
        $this -> conn -> dbDisconnect();
    }
    
    /**
    * Show sql query if option is activated
    */
    protected function showQuery($sqlQuery) {
        if(isset($_SESSION['devOpt_ShowQuery'])
           && $_SESSION['devOpt_ShowQuery']) {
            // Print sql query
            echo '<div class="log">';
            echo '<strong>SQL Query</strong>: ' . $sqlQuery;
            echo '</div>';
        }
    }
    
    /**
    * Show error message if user has developer permission
    */
    protected function showError($error) {
        if(isset($_SESSION['devOpt_ShowQuery'])
           && $_SESSION['devOpt_ShowQuery']) {
            // Print sql query
            echo '<div class="warning">';
            echo '<strong>SQL Error</strong>: ' . $error;
            echo '</div>';
        }
    }
    
    /**
    * Get first row from data set of given query
    *
    * @param mysqli_result  $dataSet    Result form an sql query
    *
    * @author David Hein
    * @return data row
    */
    public static function getFirstRow($dataSet) {
        if ($dataSet -> num_rows == 0) {
            return NULL;
        } else {
            return $dataSet -> fetch_assoc();
        }
    }
    
    /**
    * Select mysqli_result from an given id
    *
    * @param string $table  Table from where the data will be selected
    * @param int    $givenId    Id of data row which will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectWhereId($table, $givenId) {
        $sqlQuery = "SELECT * FROM ". $this -> conn -> getDatabaseName() . ".$table WHERE id = ?";
        $stmt = $this -> conn -> connectionString -> prepare($sqlQuery);
        $stmt -> bind_param('i', $id);
        // Query for developer
        $this -> showQuery($sqlQuery);
        // Assign values
        $id = $givenId;
        // Execute query
        if (!$stmt -> execute()) {
            $this -> showError($stmt -> error);
            return NULL;
        } else {
            return $this -> getFirstRow($stmt -> get_result());
        }
    }
    
    /**
    * Delete entry in table with an given id
    *
    * @param string $table  Table from where the data will be deleted
    * @param int    $givenId    Id of data row which will be deleted
    *
    * @author David Hein
    * @return boolean
    */
    public function deleteWhereId($table, $givenId) {
        $sqlQuery = "DELETE FROM ". $this -> conn -> getDatabaseName() . ".$table WHERE id = ?";
        $stmt = $this -> conn -> connectionString -> prepare($sqlQuery);
        $stmt -> bind_param('i', $id);
        // Query for developer
        $this -> showQuery($sqlQuery);
        // Assign values
        $id = $givenId;
        // Execute query
        return $stmt -> execute();
    }
}

?>