<?php
/**
* Generate a data table out of a data set
*
* The class contains static functions to generate data tables.
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
class dataTable {
    /**
    * Generate a table 
    *
    * @param dataSet    $dataSet    Data which will be shown
    * @param string     $tableId    Id for table. E.g. needed for filterData.js
    * @param array of string    $columns    All columns which will be shown as a column in the table
    * @param array of string    $headings   This headings will be shown as columns heading
    * @param array of string    $actions    Name of the action which will be given in the GET param 'action'
    * @param array of string    $actionNames    Name which will be shown in the action dropdown
    *
    * @Author: David Hein
    */
    private static function generateTable($dataSet, $tableId, $columns, $headings = NULL, $actions = NULL, $actionNames = NULL) {
        // Add id to table
        if (!is_null($tableId)) {
            echo '<table id="' . $tableId . '">';
        }
        else {
            echo '<table>';
        }
        // Add headings
        if(!is_null($headings)) {
            echo '<tr>';
            foreach($headings as $dataCol) {
                echo '<th>' . $dataCol . '</th>';
            }
            echo '</tr>';
        }
        if($dataSet -> num_rows > 0) {
            // Add a row in table for each data line
            while($row = $dataSet->fetch_assoc()) {
                echo '<tr>';
                foreach($columns as $dataCol) {
                    echo '<td>' . $row[$dataCol] . '</td>';
                }
                // Dropdown for actions
                if(!is_null($actions) && !is_null($actionNames)) {
                    echo '<td>';
                    echo '  <div class="dropdown">';
                    echo '    <button onclick="openDropdown(' . $row['id'] . ')" class="dropbtn">Aktionen</button>';
                    echo '    <div class="dropdown-content" id="dropdown-' . $row['id'] . '">';
                    $i = 0;
                    foreach($actions as $action){
                        echo '      <a href="?action=' . $action . '&id=' . $row['id'] . '">' . $actionNames[$i] . '</a>';
                        $i++;
                    }
                    echo '    </div>';
                    echo '  </div>';
                    echo '</td>';
                }
            }
        }
        echo '</table>';
    }
    
    /**
    * Generate a table with actions
    *
    * @param dataSet    $dataSet    Data which will be shown
    * @param string     $tableId    Id for table. E.g. needed for filterData.js
    * @param array of string    $columns    All columns which will be shown as a column in the table
    * @param array of string    $actions    Name of the action which will be given in the GET param 'action'
    * @param array of string    $actionNames    Name which will be shown in the action dropdown
    * @param array of string    $headings   This headings will be shown as columns heading
    *
    * @Author: David Hein
    */
    public static function showWithActions($dataSet, $tableId, $columns, $actions, $actionNames, $headings = NULL) {
        dataTable::generateTable(
            $dataSet,
            $tableId,
            $columns,
            $headings,
            $actions,
            $actionNames);
    }
    
    /**
    * Generate a table without actions
    *
    * @param dataSet    $dataSet    Data which will be shown
    * @param string     $tableId    Id for table. E.g. needed for filterData.js
    * @param array of string    $columns    All columns which will be shown as a column in the table
    * @param array of string    $headings   This headings will be shown as columns heading
    *
    * @Author: David Hein
    */
    public static function show($dataSet, $tableId, $columns, $headings = NULL) {
        dataTable::generateTable(
            $dataSet,
            $tableId,
            $columns,
            $headings);
    }
}

?>