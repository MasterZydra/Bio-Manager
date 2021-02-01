<?php
/*
* selectBox_BioManager.php
* --------------------
* This file contains the functions to generate select elements with
* options from a select result. It contains a wrapper functions
* which are preconfigured for the use in the Bio-Manager project.
*
* @Author: David Hein
*/

include 'modules/selectBox.php';

/**
* Generate a select element for the suppliers.
* The name and id of the select element is 'supplierId'.
*
* @param boolean    $isRequired     Flag if the field in the form is required
* @param int        $selectedValue  The option with this value will be selected. The default value is NULL
* @param boolean    $disableDefault Disable the default text for selection
* @param boolean    $onlyActiveUser Show only active users
*
* @Author: David Hein
* @return String with html code for select element
*/
function supplierSelectBox(
    $isRequired,
    $selectedValue = NULL,
    $disableDefault = true,
    $onlyActiveUser = false)
{
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
* The default name and id of the select element is 'plotId'.
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
* The default name and id of the select element is 'productId'.
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
* The default name and id of the select element is 'recipientId'.
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
    
    return selectBox(
        $name,
        true,
        'Bitte Abnehmer wählen',
        $result,
        $selectedValue,
        true,
        $boxReadOnly);
}

/**
* Generate a select element for the invoice years.
* The default name and id of the select element is 'invoiceYear'.
*
* @param string $name   Name of the select element
* @param int    $selectedValue  The option with this value will be selected. The default value is NULL
* @param boolean    $boxReadOnly    Set box to readonly
*
* @Author: David Hein
* @return String with html code for select element
*/
function invoiceYearsSelectBox($name = NULL, $selectedValue = NULL, $boxReadOnly = false) {
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_Invoice',
        'DISTINCT year AS value, year AS name',
        NULL,
        'year DESC');
    $conn -> dbDisconnect();
    $conn = null;
    
    if(is_null($name)) {
        $name = 'invoiceYear';
    }
    
    return selectBox(
        $name,
        true,
        'Bitte Jahr auswählen',
        $result,
        $selectedValue,
        true,
        $boxReadOnly);
}

/**
* Generate a select element for the invoices.
* The default name and id of the select element is 'invoiceId'.
*
* @param string     $name           Name of the select element
* @param int        $selectedValue  The option with this value will be selected. The default value is NULL
* @param boolean    $boxReadOnly    Set box to readonly
* @param boolean    $isRequired     Flag if the field in the form is required. The default is false
* @param boolean    $disableDefault Disable the default text for selection. The default is false
*
* @Author: David Hein
* @return String with html code for select element
*/
function invoiceSelectBox(
    $name = NULL,
    $selectedValue = NULL,
    $boxReadOnly = false,
    $isRequired = false,
    $disableDefault = false)
{
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_Invoice',
        'DISTINCT CONCAT(CAST(year AS VARCHAR(255)), " ", CAST(nr AS VARCHAR(255))) AS name, id AS value',
        NULL,
        'year DESC, nr DESC');
    $conn -> dbDisconnect();
    $conn = null;
    
    if(is_null($name)) {
        $name = 'invoiceId';
    }
    
    return selectBox(
        $name,
        $isRequired,
        'Bitte Jahr auswählen',
        $result,
        $selectedValue,
        $disableDefault,
        $boxReadOnly);
}
?>