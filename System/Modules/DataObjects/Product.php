<?php

namespace System\Modules\DataObjects;

/*
* Product.php
* -----------
* This file contains the class 'Product'.
* The class contains all informations of a product.
*
* @Author: David Hein
*/

class Product implements IObject
{
    public function __construct(
        private int $id,
        private string $name
    ) {}

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
