<?php

function dataSetToTable($dataSet, $arrayOfColumns, $tableId = NULL,  $arrayOfHeadings = NULL) {
    if (!is_null($tableId)) {
        echo '<table id="' . $tableId . '">';
    }
    else {
        echo '<table>';
    }
    // Add headings
    if (!is_null($arrayOfHeadings)) {
        echo '<tr>';
        foreach($arrayOfHeadings as $dataCol) {
            echo '<th>' . $dataCol . '</th>';
        }
        echo '</tr>';
    }
    if ($dataSet->num_rows > 0) {
        // Add a row in table for each data line
        while($row = $dataSet->fetch_assoc()) {
            echo '<tr>';
            foreach($arrayOfColumns as $dataCol) {
                echo '<td>' . $row[$dataCol] . '</td>';
            }
            echo '</tr>';
        }
    }
    echo '</table>';
}

function dataSetToTableWithDropdown($dataSet, $arrayOfColumns, $tableId = NULL,  $arrayOfHeadings = NULL) {
    if (!is_null($tableId)) {
        echo '<table id="' . $tableId . '">';
    }
    else {
        echo '<table>';
    }
    // Add headings
    if (!is_null($arrayOfHeadings)) {
        echo '<tr>';
        foreach($arrayOfHeadings as $dataCol) {
            echo '<th>' . $dataCol . '</th>';
        }
        echo '</tr>';
    }
    if ($dataSet->num_rows > 0) {
        // Add a row in table for each data line
        while($row = $dataSet->fetch_assoc()) {
            echo '<tr>';
            foreach($arrayOfColumns as $dataCol) {
                echo '<td>' . $row[$dataCol] . '</td>';
            }
            echo '<td>';
            // Dropdown
            echo '<div class="dropdown">';
            echo '  <button onclick="openDropdown(' . $row['id'] . ')" class="dropbtn">Aktionen</button>';
            echo '  <div class="dropdown-content" id="dropdown-' . $row['id'] . '">';
            echo '    <a href="?action=edit&id=' . $row['id'] . '">Bearbeiten</a>';
            echo '    <a href="?action=delete&id=' . $row['id'] . '">Löschen</a>';
            echo '  </div>';
            echo '</div>';
            
            echo '</td>';
        }
    }
    echo '</table>';
}

?>