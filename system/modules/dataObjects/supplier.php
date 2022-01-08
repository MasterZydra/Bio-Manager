<?php

/*
* supplier.php
* ----------------
* This file contains the class 'Supplier'.
* The class contains all informations of a supplier.
*
* @Author: David Hein
*/
include_once 'system/modules/dataObjects/iObject.php';

class Supplier implements iObject
{
    private int $id;
    private string $name;
    private bool $inactive;

    public function __construct(int $id, string $name, bool $inactive)
    {
        $this->id = $id;
        $this->name = $name;
        $this->inactive = $inactive;
    }

    function id(): int
    {
        return $this->id;
    }

    function name(): string
    {
        return $this->name;
    }

    function inactive(): bool
    {
        return $this->inactive;
    }

    function setName(string $name)
    {
        $this->name = $name;
    }

    function setInactive(string $inactive)
    {
        $this->inactive = $inactive;
    }

    function toArray(): array
    {
        return array(
            "id" => $this->id,
            "name" => $this->name,
            "inactive" => $this->inactive
        );
    }
}
