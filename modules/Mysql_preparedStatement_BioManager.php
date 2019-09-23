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
    
    }
}

?>