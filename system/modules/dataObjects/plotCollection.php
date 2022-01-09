<?php

/*
* plotCollection.php
* ------------------
* This file contains the class 'plotCollection'.
* The class is a data gateway for the plot and
* implements the IDataCollection interface.
*
* @Author: David Hein
*/
include_once 'system/modules/database/mySQL/MySQLPrepStatement.php';
include_once 'system/modules/database/mySQL/MySqlHelpers.php';

include_once 'system/modules/dataObjects/IDataCollection.php';
include_once 'system/modules/dataObjects/IObject.php';
include_once 'system/modules/dataObjects/plot.php';

class PlotCollection implements IDataCollection
{
    // MySQL_prepStatement
    private $prepStatement;

    // Create MySQL_prepStatement instance when creating the object
    public function __construct()
    {
        $this->prepStatement = new MySQLPrepStatement();
    }

    // Close all open connections used in class
    public function destroy()
    {
        $this->prepStatement->destroy();
    }

    // Find entry with the given id
    public function find(int $id): IObject
    {
        $dataSet = $this->prepStatement->selectWhereId("T_Plot", $id);
        $rows = $this->dataSetToArrayOfPlots($dataSet);
        if (!is_null($rows)) {
            return $rows[0];
        }
        return $rows;
    }

    // Find all entries in the table
    public function findAll(): array
    {
        $dataSet = $this->prepStatement->selectColWhereCol("*", "T_Plot", null, null);
        return $this->dataSetToArrayOfPlots($dataSet);
    }

    public function findByName(string $name)
    {
        $dataSet = $this->prepStatement->selectColWhereCol("*", "T_Plot", "name", $name, "s");
        return $this->dataSetToArrayOfPlots($dataSet);
    }

    public function update(IObject $object): bool
    {
        if (MySqlHelpers::objectAlreadyExists($this, $object->name(), $object->id())) {
            return false;
        }

        return $this->prepStatement->updateColsWhereId(
            "T_Plot",
            array("nr", "name", "subdistrict", "supplierId"),
            "sssi",
            $object->id(),
            $object->nr(),
            $object->name(),
            $object->subdistrict(),
            intval($object->supplierId())
        );
    }

    public function add(IObject $object): bool
    {
        if (MySqlHelpers::objectAlreadyExists($this, $object->name(), $object->id())) {
            return false;
        }

        return $this->prepStatement->insertCols(
            "T_Plot",
            array("nr", "name", "subdistrict", "supplierId"),
            "sssi",
            $object->nr(),
            $object->name(),
            $object->subdistrict(),
            intval($object->supplierId())
        );
    }

    private function dataSetToArrayOfPlots($dataSet)
    {
        if (is_null($dataSet) || $dataSet -> num_rows == 0) {
            return null;
        }
        // Create Plot objects for all entries and push them into the array
        $result = array();
        while ($row = $dataSet->fetch_assoc()) {
            array_push($result, $this->newPlot($row));
        }
        return $result;
    }

    private function newPlot($row): Plot
    {
        return new Plot(intval($row["id"]), $row["nr"], $row["name"], $row["subdistrict"], intval($row["supplierId"]));
    }
}
