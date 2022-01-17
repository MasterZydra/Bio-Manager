<?php

namespace System\Modules\DataObjects;

/*
* Supplier.php
* ----------------
* This file contains the class 'Supplier'.
* The class contains all informations of a supplier.
*
* @Author: David Hein
*/

class Supplier implements IObject
{
    public function __construct(
        private int $id,
        private string $name,
        private bool $inactive
    ) {}

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function inactive(): bool
    {
        return $this->inactive;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setInactive(string $inactive)
    {
        $this->inactive = $inactive;
    }

    public function toArray(): array
    {
        return array(
            "id" => $this->id,
            "name" => $this->name,
            "inactive" => $this->inactive
        );
    }
}
