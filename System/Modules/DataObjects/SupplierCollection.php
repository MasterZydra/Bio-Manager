<?php

namespace System\Modules\DataObjects;

/*
* SupplierCollection.php
* ----------------
* This file contains the class 'SupplierCollection'.
* The class is a data gateway for the suppliers and
* implements the IDataCollection interface.
*
* @Author: David Hein
*/

use System\Modules\Database\MySQL\MySqlHelpers;

class SupplierCollection implements IDataCollection
{
    // MySQL_prepStatement
    private $prepStatement;

    // Create MySQL_prepStatement instance when creating the object
    public function __construct()
    {
        $this->prepStatement = new \System\Modules\Database\MySQL\MySQLPrepStatement();
    }

    // Close all open connections used in class
    public function destroy()
    {
        $this->prepStatement->destroy();
    }

    // Find entry with the given id
    public function find(int $id): IObject
    {
        $dataSet = $this->prepStatement->selectWhereId("T_Supplier", $id);
        $rows = $this->dataSetToArrayOfSuppliers($dataSet);
        if (!is_null($rows)) {
            return $rows[0];
        }
        return $rows;
    }

    // Find all entries in the table
    public function findAll(): array
    {
        $dataSet = $this->prepStatement->selectColWhereCol("*", "T_Supplier", null, null);
        return $this->dataSetToArrayOfSuppliers($dataSet);
    }

    public function findByName(string $name)
    {
        $dataSet = $this->prepStatement->selectColWhereCol("*", "T_Supplier", "name", $name, "s");
        return $this->dataSetToArrayOfSuppliers($dataSet);
    }

    public function update(IObject $object): bool
    {
        if (MySqlHelpers::objectAlreadyExists($this, $object->name(), $object->id())) {
            return false;
        }

        return $this->prepStatement->updateColsWhereId(
            "T_Supplier",
            array("name", "inactive"),
            "sb",
            $object->id(),
            $object->name(),
            $object->inactive()
        );
    }

    public function add(IObject $object): bool
    {
        if (MySqlHelpers::objectAlreadyExists($this, $object->name(), $object->id())) {
            return false;
        }

        return $this->prepStatement->insertCols(
            "T_Supplier",
            array("name", "inactive"),
            "sb",
            $object->name(),
            $object->inactive()
        );
    }

    private function dataSetToArrayOfSuppliers($dataSet)
    {
        if (is_null($dataSet) || $dataSet -> num_rows == 0) {
            return null;
        }
        // Create Supplier objects for all entries and push them into the array
        $result = array();
        while ($row = $dataSet->fetch_assoc()) {
            array_push($result, $this->newSupplier($row));
        }
        return $result;
    }

    private function newSupplier($row): Supplier
    {
        return new Supplier(intval($row["id"]), $row["name"], $row["inactive"]);
    }
}
