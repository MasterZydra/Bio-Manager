<?php

/*
* product.php
* -----------
* This file contains the class 'Product'.
* The class contains all informations of a product.
*
* @Author: David Hein
*/
include_once 'system/modules/dataObjects/iObject.php';

class Product implements iObject
{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    function id(): int
    {
        return $this->id;
    }

    function name(): string
    {
        return $this->name;
    }

    function setName(string $name)
    {
        $this->name = $name;
    }

    function toArray(): array
    {
        return array(
            "id" => $this->id,
            "name" => $this->name
        );
    }
}
