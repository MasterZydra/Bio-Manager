<?php

/*
* productCollection.php
* ---------------------
* This file contains the class 'productCollection'.
* The class is a data gateway for the product and
* implements the iDataCollection interface.
*
* @Author: David Hein
*/
include_once 'system/modules/database/mySQL/mySQL_prepStatement.php';
include_once 'system/modules/database/mySQL/mySQL_helpers.php';

include_once 'system/modules/dataObjects/iDataCollection.php';
include_once 'system/modules/dataObjects/iObject.php';
include_once 'system/modules/dataObjects/product.php';

class ProductCollection implements iDataCollection
{
    // MySQL_prepStatement;
    private $prepStatement;

    // Create MySQL_prepStatement instance when creating the object
    public function __construct()
    {
        $this->prepStatement = new MySQL_prepStatement();
    }

    // Close all open connections used in class
    function destroy()
    {
        $this->prepStatement->destroy();
    }

    // Find entry with the given id
    public function find(int $id): iObject
    {
        $dataSet = $this->prepStatement->selectWhereId("T_Product", $id);
        $rows = $this->dataSetToArrayOfProduct($dataSet);
        if (!is_null($rows)) {
            return $rows[0];
        }
        return $rows;
    }

    // Find all entries in the table
    public function findAll(): array
    {
        $dataSet = $this->prepStatement->selectColWhereCol("*", "T_Product", null, null);
        return $this->dataSetToArrayOfProduct($dataSet);
    }

    public function findByName(string $name)
    {
        $dataSet = $this->prepStatement->selectColWhereCol("*", "T_Product", "name", $name, "s");
        return $this->dataSetToArrayOfProduct($dataSet);
    }

    public function update(iObject $object): bool
    {
        if (MySQL_helpers::objectAlreadyExists($this, $object->name(), $object->id())) {
            return false;
        }

        return $this->prepStatement->updateColsWhereId(
            "T_Product",
            array("name"),
            "s",
            $object->id(),
            $object->name()
        );
    }

    public function add(iObject $object): bool
    {
        if (MySQL_helpers::objectAlreadyExists($this, $object->name(), $object->id())) {
            return false;
        }

        return $this->prepStatement->insertCols(
            "T_Product",
            array("name"),
            "s",
            $object->name()
        );
    }

    private function dataSetToArrayOfProduct($dataSet)
    {
        if (is_null($dataSet) || $dataSet -> num_rows == 0) {
            return null;
        }
        // Create Product objects for all entries and push them into the array
        $result = array();
        while ($row = $dataSet->fetch_assoc()) {
            array_push($result, $this->newProduct($row));
        }
        return $result;
    }

    private function newProduct($row): Product
    {
        return new Product(intval($row["id"]), $row["name"]);
    }
}
