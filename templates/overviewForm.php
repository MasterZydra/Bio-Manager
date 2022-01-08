<?php

/*
* overviewForm.php
* ----------------
* Template for viewing all entries in a table.
*
* @Author: David Hein
*/

include 'templates/form.php';
include 'modules/tableGenerator.php';

/**
* The class form is generating an HTML template for an overview
* page. The content is set through properties. Indiviudal code can
* be added too.
*
* With heredity the class can be expanded for specialized pages.
*
* @author David Hein
*/
class overviewForm extends form
{
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
    function __construct()
    {
        // Create parent
        parent::__construct();
        $this -> tablePermission    = false;
        $this -> restrictedTable    = "";
        $this -> defaultTable       = "";

        $this -> resultQuery_table  = "T_Table";
        $this -> resultQuery_cols   = "*";
        $this -> resultQuery_where  = null;
        $this -> resultQuery_orderBy = null;

        $this -> alignRightColumns  = array();

        $this -> forwardingLogic    = "";
    }

    protected function showOverview()
    {
        // Script imports
        echo '<script src="js/filterDataTable.js"></script>';
        echo '<script src="js/dropdown.js"></script>';

        // Input for search field
        echo '<p>';
        echo '<input type="text" id="filterInput-data" onkeyup="filterData(&quot;data&quot;)" placeholder="Suchtext eingeben..." title="Suchtext">';
        echo '</p>';

        // Get data from DB
        $conn = new Mysql();
        $conn -> dbConnect();
        $result = $conn -> select(
            $this -> resultQuery_table,
            $this -> resultQuery_cols,
            $this -> resultQuery_where,
            $this -> resultQuery_orderBy
        );
        $conn -> dbDisconnect();
        $conn = null;

        // Show table
        if ($this -> tablePermission) {
            echo $this -> restrictedTable;
        } else {
            echo $this -> defaultTable;
        }
    }

    /**
    * Show the page content
    *
    * @param string $ownCode    If this parameter is set, the given string will be excuted
    *
    * @author David Hein
    */
    public function show()
    {
        $this -> head();
        $this -> showOverview();
        $this -> foot();/*

        // Code for page logic
        $code = file_get_contents()
            . "
            <?php
            " . $this -> forwardingLogic . "
            ?>
*/
    }
}
