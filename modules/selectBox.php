<?php
/*
* selectBox.php
* --------------------
* This file contains the functions to generate select elements with
* options from a select result.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

/**
* Generate a select element.
* The dataSet must contain the columns 'value' and 'name'.
* The value will be returned. The name will be shown.
*
* @param string     $elementName    Name of the select element for forms
* @param boolean    $isRequired     Flag if the field in the form is required
* @param string     $defaultText    This text is the preselected option. It is a placeholder.
* @param dataSet    $nameValuePairs This dataSet contains all options that will be added
*
* @Author: David Hein
* @return String with html code for select element
*/
function selectBox($elementName, $isRequired, $defaultText, $nameValuePairs) {
    // Starting tag
    $selectBox = '<select name="' . $elementName . '"';
    if($isRequired) {
        $selectBox .= ' required';
    }
    $selectBox .= '>';
    // Default value "select option"
    $selectBox .= '<option value="" selected disabled>' . $defaultText . '</option>';
    // Entries from name-value-pairs
    if($nameValuePairs -> num_rows > 0) {
        // Add a option for each row
        while($row = $nameValuePairs -> fetch_assoc()) {
            $selectBox .= '<option value="' . $row['value'] . '">';
            $selectBox .= $row['name'];
            $selectBox .= '</option>';
        }
    }
    // Endtag
    $selectBox .= '</select>';
    // Return select element
    return $selectBox;
}
?>
