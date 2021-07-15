<?php
/*
* mySQL_prepStatement.php
* ---------------------------
* Class for using prepared statments for a more secure way to
* execute sql queries and prevent sql injections.
*
* @Author David Hein
*/
include_once 'modules/Mysql.php';

class MySQL_prepStatement {
    /**
    * Mysqli object for connection to database
    * @var mysqli
    */
    protected $conn;
    
    /**
    * Create a new MySQL_prepStatement object.
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
    * @param string $colTyp     Data type of the column
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectColWhereCol(string $col, string $table, $whereCol, $givenId, $colTyp = "i") {
        $sqlQuery = "SELECT $col FROM ". $this -> conn -> getDatabaseName() . ".$table ";
        // Select with parameter
        if (!is_null($whereCol)) {
            $sqlQuery .= "WHERE $whereCol = ?";
    
            // Query for developer
            $this -> showQuery($sqlQuery);

            if ($colTyp == "i") {
                $givenId = intval($givenId);
            }

            $stmt = $this -> conn -> connectionString -> prepare($sqlQuery);
            $stmt -> bind_param($colTyp, $givenId);

            // Execute query
            if (!$stmt -> execute()) {
                $this -> showError($stmt -> error);
                return NULL;
            } else {
                return $stmt -> get_result();
            }
        }
        // Select without parameter
        else {
            return $this -> conn -> select($table, $col);
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
    * Update entry in table with an given table and id
    *
    * @param string $table      Table from where the data will be deleted
    * @param string $whereCol   Column which will be used in where condition
    * @param string $whereColTyp    Type of the where column e.g. "i", "s", "b"
    * @param int    $givenId        Id of data row which will be updated
    * @param array  $cols       Array of strings of all columns that shall be updated
    * @param string $colTyp     The types of all columns that shall be updated e.g. "sb"
    * @param        $values     All columns that shall be updated
    *
    * @author David Hein
    * @return boolean
    */
    public function updateColsWhereCol(string $table, $whereCol, string $whereColTyp, $givenId, array $cols, string $colTyp, ...$values) : bool
    {
        $sqlQuery = "UPDATE ". $this -> conn -> getDatabaseName() . ".$table SET ";
        $sqlQuerySet = "";
        foreach ($cols as $col) {
            if ($sqlQuerySet != "") {
                $sqlQuerySet .= ", ";
            }
            $sqlQuerySet .= "$col=?";
        }
        $sqlQuery .= "$sqlQuerySet WHERE $whereCol=?";

        // Query for developer
        $this -> showQuery($sqlQuery);

        $values[] = $givenId;

        $stmt = $this -> conn -> connectionString -> prepare($sqlQuery);
        $stmt -> bind_param($colTyp . $whereColTyp, ...$values);

        // Execute query
        if (!$stmt -> execute()) {
            $this -> showError($stmt -> error);
            return false;
        }
        return true;
    }

    /**
    * Insert a new entry in table with an given table
    *
    * @param string $table      Table from where the data will be deleted
    * @param array  $cols       Array of strings of all columns that shall be updated
    * @param string $colTyp     The types of all columns that shall be updated e.g. "sb"
    * @param        $values     All columns that shall be updated
    *
    * @author David Hein
    * @return boolean
    */
    public function insertCols(string $table, array $cols, string $colTyp, ...$values) : bool
    {
        $sqlQuery = "INSERT INTO ". $this -> conn -> getDatabaseName() . ".$table ";
        $sqlQueryCols = "";
        $sqlQueryValues = "";
        foreach ($cols as $col) {
            if ($sqlQueryCols != "") {
                $sqlQueryCols .= ", ";
            }
            $sqlQueryCols .= $col;

            if ($sqlQueryValues != "") {
                $sqlQueryValues .= ", ";
            }
            $sqlQueryValues .= "?";
        }
        $sqlQuery .= "($sqlQueryCols) VALUES ($sqlQueryValues)";

        // Query for developer
        $this -> showQuery($sqlQuery);

        $stmt = $this -> conn -> connectionString -> prepare($sqlQuery);
        $stmt -> bind_param($colTyp, ...$values);

        // Execute query
        if (!$stmt -> execute()) {
            $this -> showError($stmt -> error);
            return false;
        }
        return true;
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

        /**
    * Update entry in table with an given table and id
    *
    * @param string $table      Table from where the data will be deleted
    * @param string $whereCol   Column which will be used in where condition
    * @param int    $givenId        Id of data row which will be updated
    * @param array  $cols       Array of strings of all columns that shall be updated
    * @param string $colTyp     The types of all columns that shall be updated e.g. "sb"
    * @param        $values     All columns that shall be updated
    *
    * @author David Hein
    * @return boolean
    */
    public function updateColsWhereId(string $table, array $cols, string $colType, int $givenId, ...$values) : bool
    {
        return $this->updateColsWhereCol($table, "id", "i", $givenId, $cols, $colType, ...$values);
    }
}

?>