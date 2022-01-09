<?php

/**
* The class has functions to generate a data table.
*
* Important: The dataSet has to contain a column with the name 'id'.
*
* @Author: David Hein
*/

include_once 'system/modules/dataObjects/IObject.php';

class TableGenerator
{
    /**
    * Print all headings in given array.
    *
    * @param array of string    $headings   Array of headings
    *
    * @Author: David Hein
    */
    private static function printHeading($headings)
    {
        if (is_null($headings)) {
            return;
        }
        echo '<tr>';
        foreach ($headings as $heading) {
            echo '<th class="center">' . getSecuredString($heading) . '</th>';
        }
        echo '</tr>';
    }

    /**
    * Print a formatted table cell
    * Supported data types: bool, date, float, int, currency
    *
    * @param string $dataType   Data type of the $data
    * @param string $data       Data which will be formatted and printed
    *
    * @Author: David Hein
    */
    private static function printFormattedCell($dataType, $data)
    {
        echo '<td';
        // Formatting
        switch ($dataType) {
            case 'bool':
            case 'date':
                echo ' class="center"';
                break;
            case 'float':
            case 'int':
            case 'currency':
                echo ' class="right"';
                break;
        }
        echo '>';
        // Data output
        switch ($dataType) {
            case 'bool':
                echo ($data == "1") ? 'Ja' : 'Nein';
                break;
            case 'date':
                echo DateTime::createFromFormat('Y-m-d', $data)->format('d.m.Y');
                break;
            case 'float':
                echo number_format($data, 2, ',', '.');
                break;
            case 'currency':
                echo number_format($data, 2, ',', '.') . ' €';
                break;
            default:
                echo getSecuredString($data);
        }
        echo '</td>';
    }

    private static function generateTable(
        $tableId,
        $dataSet,
        $columns,
        $headings = null,
        $actions = null,
        $actionNames = null,
        $openInNewTab = false,
        $useCompleteWidth = false
    ) {
        // Add attribute id
        if (!is_null($tableId)) {
            echo '<table id="' . getSecuredString($tableId) . '"';
        } else {
            echo '<table';
        }
        // Use complete width
        if ($useCompleteWidth) {
            echo ' class="completeWidth"';
        }
        // Close table tag
        echo '>';
        // Add headings
        TableGenerator::printHeading($headings);

        if (is_array($dataSet) || $dataSet -> num_rows > 0) {
            $dataSetNotEmpty = true;
            $loopCount = 0;
            // Add a row in table for each data line
            while ($dataSetNotEmpty) {
                $row = null;

                // Get next row
                if (gettype($dataSet) === "object") {
                    $row = $dataSet->fetch_assoc();
                }
                if (is_array($dataSet) && $loopCount < count($dataSet)) {
                    $row = $dataSet[$loopCount]->toArray();
                }

                // Break loop if all items are processed
                $dataSetNotEmpty = !is_null($row);
                if (!$dataSetNotEmpty) {
                    continue;
                }

                echo '<tr>';
                foreach ($columns as $dataCol) {
                    // If data type is given, format output
                    if (is_array($dataCol)) {
                        // First element is column name
                        $data = $row[$dataCol[0]];
                        // Second element is data type
                        $dataType = $dataCol[1];
                    } else {
                        $data = $row[$dataCol];
                        $dataType = '';
                    }
                    // Print cells with data
                    TableGenerator::printFormattedCell($dataType, $data);
                }
                if (is_null($actions) || is_null($actionNames)) {
                    continue;
                }
                // Dropdown for actions
                echo '<td>';
                echo '<div class="dropdown">';
                echo '<button onclick="openDropdown(' . getSecuredString($row['id']) . ')" class="dropbtn">'
                    . 'Aktionen</button>';
                echo '<div class="dropdown-content" id="dropdown-' . $row['id'] . '">';
                for ($i = 0; $i < count($actions); $i++) {
                    echo '<a href="?action=' . getSecuredString($actions[$i]) . '&id=' . getSecuredString($row['id'])
                        . '"';
                    if (
                        (gettype($openInNewTab) === "boolean" && $openInNewTab) ||
                        (gettype($openInNewTab) === "array" && $openInNewTab[$i])
                    ) {
                        echo ' target="_blank"';
                    }
                    echo '>' . getSecuredString($actionNames[$i]) . '</a>';
                }
                echo '</div></div></td>';
                $loopCount += 1;
            }
        }
        echo '</table>';
    }

    /**
    * Show table for give parameters
    *
    * @param string             $tableId        Name of table for id attribute
    * @param dataSet            $dataSet        All data which shall be shown in table
    * @param array of string    $columns        Name of the columns. Optional a column name
    *                                           can be put into an array and have the data type as second value.
    *                                           E.g. ['col1', ['col2', 'dataType']]
    * @param array of string    $headings       Headings for the columns. (Optional)
    * @param array of string    $actions     Name of the action which will be given in the GET param 'action' (Optional)
    * @param array of string    $actionNames    Name which will be shown in the action dropdown (Optional)
    * @param boolean/array of boolean   $openInNewTab   Open link in new tab. Array if only selected actions shall open
    *                                   in new tab (Optional)
    * @param boolean    $useCompleteWidth   Show table over complete window width. Default value is false
    *
    * @Author: David Hein
    */
    public static function show(
        $tableId,
        $dataSet,
        $columns,
        $headings = null,
        $actions = null,
        $actionNames = null,
        $openInNewTab = false,
        $useCompleteWidth = false
    ) {
        TableGenerator::generateTable(
            $tableId,
            $dataSet,
            $columns,
            $headings,
            $actions,
            $actionNames,
            $openInNewTab,
            $useCompleteWidth
        );
    }
}
