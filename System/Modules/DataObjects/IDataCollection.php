<?php

/*
* IDataCollection.php
* ----------------
* This file contains the interface 'IDataCollection'.
* The interace has to be implemented for all classes that
* are collections of data objects.
*
* @Author: David Hein
*/
include_once 'system/modules/dataObjects/IObject.php';

interface IDataCollection
{
    public function find(int $id): IObject;
    public function findAll();
    public function add(IObject $object): bool;
    public function update(IObject $object): bool;
}
