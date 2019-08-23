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
    $result = $conn -> select('T_UserPermission', $permission, 'userId =' . $userId);
    $conn -> dbDisconnect();
    $conn = NULL;
    
    if ($result -> num_rows == 0) {
        return false;
    }
    else {
        $row = $result->fetch_assoc();
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
*
* @author David Hein
*/
function updateSupplier($conn, $id, $name) {
    $conn -> update(
        'T_Supplier',
        'name = \'' . $name .'\'',
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

?>