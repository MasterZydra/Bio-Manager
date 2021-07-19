<?php
/*
* plot.php
* --------
* This file contains the class 'Plot'.
* The class contains all informations of a plot.
*
* @Author: David Hein
*/
include_once 'system/modules/dataObjects/iObject.php';
include_once 'system/modules/dataObjects/supplierCollection.php';

class Plot implements iObject
{
    private int $id;
    private string $nr;
    private string $name;
    private string $subdistrict;
    private int $supplierId;

    public function __construct(int $id, string $nr, string $name, string $subdistrict, int $supplierId)
    {
        $this->id = $id;
        $this->nr = $nr;
        $this->name = $name;
        $this->subdistrict = $subdistrict;
        $this->supplierId = $supplierId;
    }

    function id() : int
    {
        return $this->id;
    }

    function nr() : string
    {
        return $this->nr;
    }

    function name() : string
    {
        return $this->name;
    }

    function subdistrict() : string
    {
        return $this->subdistrict;
    }

    function supplierId() : int
    {
        return $this->supplierId;
    }

    function setNr(string $nr) {
        $this->nr = $nr;
    }

    function setName(string $name) {
        $this->name = $name;
    }

    function setSubdistrict(string $subdistrict) {
        $this->subdistrict = $subdistrict;
    }

    function setSupplierId(int $supplierId) {
        $this->supplierId = $supplierId;
    }

    function toArray(): array
    {
        $supplierColl = new SupplierCollection();
        return array(
            "id" => $this->id,
            "nr" => $this->nr,
            "name" => $this->name,
            "subdistrict" => $this->subdistrict,
            "supplierId" => $this->supplierId,
            "supplierName" => $supplierColl->find($this->supplierId)->name()
        );
    }
}