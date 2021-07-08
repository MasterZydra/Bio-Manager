<?php
/*
* mySQL_helpers.php
* -----------------
* This file contains the class 'MySQL_helpers'.
* The class contains static functions that encapsulate logic
* e.g. to check if a supplier already exists by using the existing
* prepared statements.
*
* @Author: David Hein
*/
include_once 'system/modules/dataObjects/supplierCollection.php';

class MySQL_helpers {
    public static function supplierAlreadyExists(string $name, int $id) : bool
    {
        $supplierColl = new SupplierCollection();
        $suppliers = $supplierColl->findByName($name);
        if (is_null($suppliers)) {
            return false;
        }

        foreach ($suppliers as $supplier) {
            if ($supplier->id() != $id) {
                return true;
            }
        }
        return false;
    }
}

?>