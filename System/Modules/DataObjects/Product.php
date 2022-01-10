<?php

/*
* Product.php
* -----------
* This file contains the class 'Product'.
* The class contains all informations of a product.
*
* @Author: David Hein
*/
include_once 'System/Modules/DataObjects/IObject.php';

class Product implements IObject
{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function toArray(): array
    {
        return array(
            "id" => $this->id,
            "name" => $this->name
        );
    }
}
