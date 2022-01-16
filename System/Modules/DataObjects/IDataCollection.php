<?php

namespace System\Modules\DataObjects;

/*
* IDataCollection.php
* ----------------
* This file contains the interface 'IDataCollection'.
* The interace has to be implemented for all classes that
* are collections of data objects.
*
* @Author: David Hein
*/

interface IDataCollection
{
    public function find(int $id): IObject|null;
    public function findAll();
    public function add(IObject $object): bool;
    public function update(IObject $object): bool;
}
