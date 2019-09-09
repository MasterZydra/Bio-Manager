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
    * Construct a new overviewForm object and set default values for the properties
    *
    * @author David Hein
    */
    function __construct() {
        // Create parent
        parent::__construct();
    }
    
    /**
    * Show the page content
    *
    * @param string $ownCode    If this parameter is set, the given string will be excuted
    *
    * @author David Hein
    */
    function show($ownCode = "") {
        $code = file_get_contents('modules/dataTable_BioManager.php')
            . "<script src=\"js/filterDataTable.js\"></script>
            <script src=\"js/dropdown.js\"></script>
            <p>
                <input type=\"text\" id=\"filterInput-data\" onkeyup=\"filterData(&quot;data&quot;)\" placeholder=\"Suchtext eingeben...\" title=\"Suchtext\"> 
            </p>";

        parent::show($code);
    }
}
?>