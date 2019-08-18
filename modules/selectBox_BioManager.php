<?php
/*
* selectBox_BioManager.php
* --------------------
* This file contains the functions to generate select elements with
* options from a select result. It contains a wrapper functions
* which are preconfigured for the use in the Bio-Manager project.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

include 'modules/selectBox.php';

/**
* Generate a select element for the suppliers.
* The name of the select element is 'supplierId'.
*
* @param boolean    $isRequired     Flag if the field in the form is required
*
* @Author: David Hein
* @return String with html code for select element
*/
function supplierSelectBox($isRequired) {
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select('T_Supplier', 'id AS value, name', NULL, 'name ASC');
    $conn -> dbDisconnect();
    $conn = NULL;
    
    return selectBox('supplierId', $isRequired, 'Bitte Lieferant wählen', $result);
}
?>
