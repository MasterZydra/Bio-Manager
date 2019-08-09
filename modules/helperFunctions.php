<?php

function dataSetToTable($dataSet, $arrayOfColumns, $arrayOfHeadings = NULL) {
    if ($dataSet->num_rows > 0) {
        echo '<table>';
        // Add headings
        if (!is_null($arrayOfHeadings)) {
            echo '<tr>';
            foreach($arrayOfHeadings as $dataCol) {
                echo '<th>' . $dataCol . '</th>';
            }
            echo '</tr>';
        }
        // Add a row in table for each data line
        while($row = $dataSet->fetch_assoc()) {
            echo '<tr>';
            foreach($arrayOfColumns as $dataCol) {
                echo '<td>' . $row[$dataCol] . '</td>';
            }
        }
        echo '</table>';
    }
}

?>