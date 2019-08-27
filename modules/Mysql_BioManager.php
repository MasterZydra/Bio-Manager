<?php
/*
* Mysql_BioManager.php
* --------------------
* This file contains the functions for a simpler use of SQL queries.
* The functions use the Mysql class and only have the minimum parameters.
* The table name is coded in the function.
*
* This has the advantage that by using this functions, this is the only
* place where the queries have to be changed.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

/*
* Get a permission for a given user id.
*
* @param int    $userId     User id of the user whose permission is requested
* @param string $permission Permission name
*
* @author David Hein
* @return false if not no data has been found.
*/
function getUserPermission($userId, $permission) {
    // Get user permissions
    $conn = new Mysql();
    $conn -> dbConnect();
    $conn -> select('T_UserPermission', $permission, 'userId =' . $userId);
    $row = $conn -> getFirstRow();
    $conn -> dbDisconnect();
    $conn = NULL;
    
    if (is_null($row)) {
        return false;
    }
    else {
        return $row[$permission];
    }
    return false;
}

/**
* Update a supplier
*
* @param DbConnection   $conn   Connection to data base
* @param int            $id     Supplier id
* @param string         $name   New supplier name
* @param tinyint    $inactive   Flag if user is inactive
*
* @author David Hein
*/
function updateSupplier($conn, $id, $name, $inactive) {
    $conn -> update(
        'T_Supplier',
        'name = \'' . $name .'\', '
        . 'inactive = ' . $inactive,
        'id = ' . $id);
}

/**
* Get next delivery note number
*
* @param DbConnection   $conn   Connection to data base
* @param int            $year   Year of delivery
*
* @author David Hein
* @return If no delivery exists, it return 1. Else the next number is returned.
*/
function getNextDeliveryNoteNr($conn, $year) {
    $conn -> select('T_DeliveryNote', '(MAX(nr) + 1) AS nextId', 'year = ' . $year);
    $row = $conn -> getFirstRow();
    if(is_null($row) || is_null($row['nextId'])) {
        return 1;
    }
    return $row['nextId'];
}

/**
* Get next invoice number
*
* @param DbConnection   $conn   Connection to data base
* @param int            $year   Year of invoice
*
* @author David Hein
* @return If no invoice exists, it return 1. Else the next number is returned.
*/
function getNextInvoiceNr($conn, $year) {
    $conn -> select('T_Invoice', '(MAX(nr) + 1) AS nextId', 'year = ' . $year);
    $row = $conn -> getFirstRow();
    if(is_null($row) || is_null($row['nextId'])) {
        return 1;
    }
    return $row['nextId'];
}

/*
* Get settings
*
* @param string $setting    Setting name
*
* @author David Hein
* @return false if not no data has been found.
*/
function getSetting($setting) {
    // Get setting
    $conn = new Mysql();
    $conn -> dbConnect();
    $conn -> select('T_Setting', 'value', 'name =\'' . $setting . '\'');
    $row = $conn -> getFirstRow();
    $conn -> dbDisconnect();
    $conn = NULL;
    
    if (is_null($row)) {
        return false;
    }
    else {
        return $row['value'];
    }
    return false;
}

/*
* Get delivery notes
*
* @param boolean    $isComplete true returns complete only complete and false uncomplete delivery notes
* @param int    $year   Year of the delivery note. NULL if year shall not be checked
* @param int    $invoiceId  Id of the invoice
* @param boolean    $joinSupplier   Join the supplier name to query
* @param boolean    $invertSort Invert the sort order of the delivery notes
* @param boolean    $isUnused   Return only delivery notes which are not bound to an invoice
*
* @author David Hein
* @return data set of delivery notes
*/
function getDeliveryNotes($isComplete = true, $year = NULL, $invoiceId = NULL, $joinSupplier = true, $invertSort = false, $isUnused = false) {
    if($isComplete) {
        $whereCondition =
            '(deliverDate IS NOT NULL '
            . 'AND amount IS NOT NULL '
            . 'AND supplierId IS NOT NULL)';
    } else {
        $whereCondition =
            '(deliverDate IS NULL '
            . 'OR amount IS NULL '
            . 'OR supplierId IS NULL)'
            . ' AND invoiceId IS NULL';
    }
    
    if(!is_null($year)) {
        $whereCondition .= ' AND year = ' . $year;
    }
    
    if(!is_null($invoiceId)) {
        $whereCondition .= ' AND invoiceId = ' . $invoiceId;
    }
    
    if($isUnused) {
        $whereCondition .= ' AND invoiceId IS NULL';
    }
    
    $from = 'T_DeliveryNote';
    $select = 'T_DeliveryNote.id, year, nr, amount, deliverDate, productId';
    if($joinSupplier) {
        $from .= ' LEFT JOIN T_Supplier ON T_Supplier.id = supplierId';
        $select .= ', T_Supplier.name AS supplierName';
    }
    
    if($invertSort) {
        $orderBy = 'year DESC, nr ASC';
    } else {
        $orderBy = 'year DESC, nr DESC';
    }
    
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        $from,
        $select,
        $whereCondition,
        $orderBy);
    $conn -> dbDisconnect();
    $conn = NULL;
    
    if ($result -> num_rows == 0) {
        return false;
    }
    else {
        return $result;
    }
    return false;
}

/*
* Check if supplier already exists
*
* @param string $supplier   Supplier name
*
* @author David Hein
* @return true if supplier already exists
*/
function alreadyExistsSupplier($supplier) {
    $conn = new Mysql();
    $conn -> dbConnect();
    $conn -> select('T_Supplier', 'id', 'name =\'' . $supplier . '\'');
    $row = $conn -> getFirstRow();
    $conn -> dbDisconnect();
    $conn = NULL;
    
    return !is_null($row);
}

?>