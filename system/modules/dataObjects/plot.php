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

class Plot implements IObject
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

    public function id(): int
    {
        return $this->id;
    }

    public function nr(): string
    {
        return $this->nr;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function subdistrict(): string
    {
        return $this->subdistrict;
    }

    public function supplierId(): int
    {
        return $this->supplierId;
    }

    public function setNr(string $nr)
    {
        $this->nr = $nr;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setSubdistrict(string $subdistrict)
    {
        $this->subdistrict = $subdistrict;
    }

    public function setSupplierId(int $supplierId)
    {
        $this->supplierId = $supplierId;
    }

    public function toArray(): array
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
