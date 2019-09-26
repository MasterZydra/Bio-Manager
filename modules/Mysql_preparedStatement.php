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
    * Select mysqli_result from an given column, table, where column and id
    *
    * @param string $col    Column which will be selected
    * @param string $table  Table from where the data will be selected
    * @param string $whereCol   Column which will be used in where condition
    * @param int    $givenId    Id of data row which will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectColWhereCol($col, $table, $whereCol, $givenId) {
        $sqlQuery = "SELECT $col FROM ". $this -> conn -> getDatabaseName() . ".$table WHERE $whereCol = ?";
        $stmt = $this -> conn -> connectionString -> prepare($sqlQuery);
        $stmt -> bind_param('i', $id);
        // Query for developer
        $this -> showQuery($sqlQuery);
        // Assign values
        $id = intval($givenId);
        // Execute query
        if (!$stmt -> execute()) {
            $this -> showError($stmt -> error);
            return NULL;
        } else {
            return $this -> getFirstRow($stmt -> get_result());
        }
    }
    
    /**
    * Delete entry in table with an given table and id
    *
    * @param string $table  Table from where the data will be deleted
    * @param string $whereCol   Column which will be used in where condition
    * @param int    $givenId    Id of data row which will be deleted
    *
    * @author David Hein
    * @return boolean
    */
    public function deleteWhereCol($table, $whereCol, $givenId) {
        $sqlQuery = "DELETE FROM ". $this -> conn -> getDatabaseName() . ".$table WHERE $whereCol = ?";
        $stmt = $this -> conn -> connectionString -> prepare($sqlQuery);
        $stmt -> bind_param('i', $id);
        // Query for developer
        $this -> showQuery($sqlQuery);
        // Assign values
        $id = intval($givenId);
        // Execute query
        return $stmt -> execute();
    }
    
    /**
    * Select mysqli_result from an given column, table, where column and id
    *
    * @param string $table  Table from where the data will be selected
    * @param int    $givenId    Id of data row which will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectWhereId($table, $givenId) {
        return $this -> selectColWhereCol("*", $table, "id", $givenId);
    }
    
    /**
    * Select mysqli_result from an given column, table, where column and id
    *
    * @param string $col    Column which will be selected
    * @param string $table  Table from where the data will be selected
    * @param int    $givenId    Id of data row which will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectColWhereId($col, $table, $givenId) {
        return $this -> selectColWhereCol($col, $table, "id", $givenId);
    }
    
    /**
    * Delete entry in table with an given table and id
    *
    * @param string $table  Table from where the data will be deleted
    * @param int    $givenId    Id of data row which will be deleted
    *
    * @author David Hein
    * @return boolean
    */
    public function deleteWhereId($table, $givenId) {
        $this -> deleteWhereCol($table, "id", $givenId);
    }
}

?>