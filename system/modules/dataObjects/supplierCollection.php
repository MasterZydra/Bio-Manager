<?php
/*
* supplierCollection.php
* ----------------
* This file contains the class 'supplierCollection'.
* The class is a data gateway for the suppliers and
* implements the iDataCollection interface.
*
* @Author: David Hein
*/
include_once 'system/modules/database/mySQL/mySQL_prepStatement.php';

include_once 'system/modules/dataObjects/iDataCollection.php';
include_once 'system/modules/dataObjects/iObject.php';
include_once 'system/modules/dataObjects/supplier.php';

class SupplierCollection implements iDataCollection
{
    // MySQL_prepStatement
    private $prepStatement;

    // Create MySQL_prepStatement instance when creating the object
    public function __construct() {
        $this->prepStatement = new MySQL_prepStatement();
    }

    // Find entry with the given id
    public function find(int $id) : iObject
    {
        $row = $this->prepStatement->selectWhereId("T_Supplier", $id);
        if (is_null($row)) {
            return NULL;
        }
        return $this->newSupplier($row);
    }

    // Find all entries in the table
    public function findAll() : array {
        $dataSet = $this->prepStatement->selectColWhereCol("*", "T_Supplier", NULL, NULL);
        if (is_null($dataSet) || $dataSet -> num_rows == 0) {
            return NULL;
        }
        // Create Supplier objects for all entries and push them into the array
        $result = array();
        while($row = $dataSet->fetch_assoc()) {
            array_push($result, $this->newSupplier($row));
        }
        return $result;
    }

    public function delete(int $id)
    {

    }

    private function newSupplier($row) : Supplier {
        return new Supplier(intval($row["id"]), $row["name"], $row["inactive"]);
    }
}

?>