<?php

include 'modules/dataTable.php';
/**
* Generate a data table out of a data set
*
* The class contains static functions to generate data tables.
* This class extends the dataTable class with predefined parameters for
* a more central managment of the actions.
*
* Important: The dataSet need to have a column with the name 'id'.
*
* Usage:
* ------
* On a click to the drowpdown action the current URL with the GET parameters
* 'edit' and 'id' is called. Action contains the given action name from the
* function parameter $actions. The id is the id from the data row.
*
* For showing the dropdown the JavaScript file dropdown.js needs to be included:
* <script src="js/dropdown.js"></script>
*
* @Author: David Hein
*
* Changelog:
* ----------
*/
class dataTable_BioManager extends dataTable {
    /**
    * Generate a table without default actions (edit and delete)
    *
    * @param dataSet    $dataSet    Data which will be shown
    * @param string     $tableId    Id for table. E.g. needed for filterData.js
    * @param array of string    $columns    All columns which will be shown as a column in the table
    * @param array of string    $headings   This headings will be shown as columns heading
    *
    * @Author: David Hein
    */
    public static function showWithDefaultActions($dataSet, $tableId, $columns, $headings = NULL) {
        dataTable_BioManager::showWithActions(
            $dataSet,
            $tableId,
            $columns,
            array('edit', 'delete'),
            array('Bearbeiten', 'Löschen'),
            $headings);
    }

    /**
    * Generate a table without actions for user (edit, delete and change password)
    *
    * @param dataSet    $dataSet    Data which will be shown
    * @param string     $tableId    Id for table. E.g. needed for filterData.js
    * @param array of string    $columns    All columns which will be shown as a column in the table
    * @param array of string    $headings   This headings will be shown as columns heading
    *
    * @Author: David Hein
    */
    public static function showWithUserActions($dataSet, $tableId, $columns, $headings = NULL) {
        dataTable_BioManager::showWithActions(
            $dataSet,
            $tableId,
            $columns,
            array('edit', 'changePwd', 'delete'),
            array('Bearbeiten', 'Passwort ändern', 'Löschen'),
            $headings);
    }
}

?>