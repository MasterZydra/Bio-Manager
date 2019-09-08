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
* 19.08.2019:
*   - Add parameter $selectedValue
* 23.08.2019:
*   - Add parameter $onlyActiveUser
*/

include 'modules/selectBox.php';

/**
* Generate a select element for the suppliers.
* The name of the select element is 'supplierId'.
*
* @param boolean    $isRequired     Flag if the field in the form is required
* @param int        $selectedValue  The option with this value will be selected. The default value is NULL
* @param boolean    $disableDefault Disable the default text for selection
* @param boolean    $onlyActiveUser Show only active users
*
* @Author: David Hein
* @return String with html code for select element
*/
function supplierSelectBox($isRequired, $selectedValue = NULL, $disableDefault = true, $onlyActiveUser = false) {
    $where = NULL;
    if($onlyActiveUser) {
        $where = 'inactive = 0';
    }
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select('T_Supplier', 'id AS value, name', $where, 'name ASC');
    $conn -> dbDisconnect();
    $conn = NULL;
    
    return selectBox('supplierId', $isRequired, 'Bitte Lieferant wählen', $result, $selectedValue, $disableDefault);
}

/**
* Generate a select element for the plots.
* The default name of the select element is 'plotId'.
*
* @param string $name   Name of the select element
* @param int    $selectedValue  The option with this value will be selected. The default value is NULL
*
* @Author: David Hein
* @return String with html code for select element
*/
function plotSelectBox($name = NULL, $selectedValue = NULL) {
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_Plot',
        'id AS value, CONCAT(nr, " ", name) as name',
        NULL,
        'nr ASC, name ASC');
    $conn -> dbDisconnect();
    $conn = NULL;
    
    if(is_null($name)) {
        $name = 'plotId';
    }
    
    return selectBox($name, true, 'Bitte Flurstück wählen', $result, $selectedValue);
}

/**
* Generate a select element for the product.
* The default name of the select element is 'productId'.
*
* @param string $name   Name of the select element
* @param int    $selectedValue  The option with this value will be selected. The default value is NULL
*
* @Author: David Hein
* @return String with html code for select element
*/
function productSelectBox($name = NULL, $selectedValue = NULL) {
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_Product',
        'id AS value, name',
        NULL,
        'name ASC');
    $conn -> dbDisconnect();
    $conn = NULL;
    
    if(is_null($name)) {
        $name = 'productId';
    }
    
    return selectBox($name, true, 'Bitte Produkt wählen', $result, $selectedValue);
}

/**
* Generate a select element for the recipient.
* The default name of the select element is 'recipientId'.
*
* @param string $name   Name of the select element
* @param int    $selectedValue  The option with this value will be selected. The default value is NULL
* @param boolean    $boxReadOnly    Set box to readonly
*
* @Author: David Hein
* @return String with html code for select element
*/
function recipientSelectBox($name = NULL, $selectedValue = NULL, $boxReadOnly = false) {
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_Recipient',
        'id AS value, name',
        NULL,
        'name ASC');
    $conn -> dbDisconnect();
    $conn = NULL;
    
    if(is_null($name)) {
        $name = 'recipientId';
    }
    
    return selectBox($name, true, 'Bitte Abnehmer wählen', $result, $selectedValue, true , $boxReadOnly);
}
?>