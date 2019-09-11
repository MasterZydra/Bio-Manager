<?php
/*
* overviewForm.php
* ----------------
* Template for viewing all entries in a table.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

include 'templates/form.php';

/**
* The class form is generating an HTML template for an overview
* page. The content is set through properties. Indiviudal code can
* be added too.
*
* With heredity the class can be expanded for specialized pages.
*
* @author David Hein
*/
class overviewForm extends form {
    /**
    * Permission that is necessary to see one table. If false the default table will be shown.
    * The string is inserted as if condition. E.g. "isMaintainer()"
    * @var string
    */
    public $tablePermission;
    /**
    * This table will be shown if permission is is true.
    * @var string
    */
    public $restrictedTable;
    /**
    * This table will be shown if permission is is false.
    * @var string
    */
    public $defaultTable;

    /**
    * Table from which the data will be selected.
    * @var string
    */
    public $resultQuery_table;
    /**
    * Columns which will be selected.
    * @var string
    */
    public $resultQuery_cols;
    /**
    * Where condition for the select statement.
    * NULL if no where condition shall be used.
    * @var string
    */
    public $resultQuery_where;
    /**
    * Order by for the select statement.
    * NULL if no order by shall be used.
    * @var string
    */
    public $resultQuery_orderBy;
    
    /**
    * Array of column indexes where the text shall be aligned right
    * @var array
    */
    public $alignRightColumns;
    
    public $forwardingLogic;
    
    /**
    * Construct a new overviewForm object and set default values for the properties
    *
    * @author David Hein
    */
    function __construct() {
        // Create parent
        parent::__construct();
        $this -> tablePermission    = "false";
        $this -> restrictedTable    = "";
        $this -> defaultTable       = "";
        
        $this -> resultQuery_table  = "T_Table";
        $this -> resultQuery_cols   = "*";
        $this -> resultQuery_where  = NULL;
        $this -> resultQuery_orderBy = NULL;
        
        $this -> alignRightColumns  = array();
        
        $this -> forwardingLogic    = "";
    }
    
    /**
    * Show the page content
    *
    * @param string $ownCode    If this parameter is set, the given string will be excuted
    *
    * @author David Hein
    */
    function show($ownCode = "") {
        // Generate script part for formatting the text alignement
        $script = "";
        $i = 0;
        while(count($this -> alignRightColumns) > $i && $this -> alignRightColumns[$i] != NULL) {
            $script .= "formatTableCellRight(\"dataTable-data\", " . strval($this -> alignRightColumns[$i]) . ");";
            $i++;
        }
        
        // Check if where is NULL or condition is given
        if (is_null($this -> resultQuery_where)) {
            $this -> resultQuery_where = "NULL";
        } else {
            $this -> resultQuery_where = "'" . $this -> resultQuery_where . "'";
        }
        
        // Check if order by is NULL or given
        if (is_null($this -> resultQuery_orderBy)) {
            $this -> resultQuery_orderBy = "NULL";
        } else {
            $this -> resultQuery_orderBy = "'" . $this -> resultQuery_orderBy . "'";
        }
        
        // Code for page logic
        $code = file_get_contents('modules/dataTable_BioManager.php')
            . "
            <?php
            " . $this -> forwardingLogic . "
            ?>
            
            <script src=\"js/filterDataTable.js\"></script>
            <script src=\"js/dropdown.js\"></script>
            <script src=\"js/formatTableCellRight.js\"></script>
            <p>
                <input type=\"text\" id=\"filterInput-data\" onkeyup=\"filterData(&quot;data&quot;)\" placeholder=\"Suchtext eingeben...\" title=\"Suchtext\"> 
            </p>
            <?php
                \$conn = new Mysql();
                \$conn -> dbConnect();
                \$result = \$conn -> select(
                    '" . $this -> resultQuery_table . "',
                    '" . $this -> resultQuery_cols . "',
                    " . $this -> resultQuery_where . ",
                    " . $this -> resultQuery_orderBy . ");
                \$conn -> dbDisconnect();
                \$conn = NULL;
            
                if(" . $this -> tablePermission . ") {"
                . $this -> restrictedTable .
                "} else {"
                . $this -> defaultTable .
                "}
            ?>
            <script>"
            . $script .
            "</script>
            ";

        parent::show($code);
    }
}
?>