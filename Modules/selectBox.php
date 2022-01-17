<?php

/*
* selectBox.php
* --------------------
* This file contains the functions to generate select elements with
* options from a select result.
*
* @Author: David Hein
*/

/**
* Generate a select element.
* The dataSet must contain the columns 'value' and 'name'.
* The value will be returned. The name will be shown.
*
* @param string     $elementName    Name and id of the select element for forms
* @param boolean    $isRequired     Flag if the field in the form is required
* @param string     $defaultText    This text is the preselected option. It is a placeholder.
* @param dataSet    $nameValuePairs This dataSet contains all options that will be added
* @param string/int $selectedValue  The option with this value will be selected. The default value is NULL
* @param boolean    $disableDefault Disable the default text for selection
* @param boolean    $boxReadOnly    Set box to readonly
*
* @Author: David Hein
* @return String with html code for select element
*/
function selectBox(
    $elementName,
    $isRequired,
    $defaultText,
    $nameValuePairs,
    $selectedValue = null,
    $disableDefault = true,
    $boxReadOnly = false
) {
    // Starting tag
    $selectBox = '<select id="' . getSecuredString($elementName) . '" name="' . getSecuredString($elementName) . '"';
    if ($isRequired) {
        $selectBox .= ' required';
    }
    if ($boxReadOnly) {
        $selectBox .= ' disabled';
    }
    $selectBox .= '>';

    // Default value "select option"
    $selectBox .= '<option value=""';
    if ($disableDefault) {
        $selectBox .= ' disabled';
    }
    if (is_null($selectedValue)) {
        $selectBox .= ' selected';
    }
    $selectBox .= '>' . getSecuredString($defaultText) . '</option>';

    // Entries from name-value-pairs
    if ($nameValuePairs -> num_rows > 0) {
        // Add a option for each row
        while ($row = $nameValuePairs -> fetch_assoc()) {
            $selectBox .= "<option value='" . getSecuredString($row['value']) . "'";
            if ($row['value'] == $selectedValue) {
                $selectBox .= ' selected';
            }
            $selectBox .= ">" . getSecuredString($row['name']) . "</option>";
        }
    }
    // Endtag
    $selectBox .= '</select>';
    // Return select element
    return $selectBox;
}