<?php

/*
* iDataCollection.php
* ----------------
* This file contains the interface 'iDataCollection'.
* The interace has to be implemented for all classes that
* are collections of data objects.
*
* @Author: David Hein
*/
include_once 'system/modules/dataObjects/iObject.php';

interface iDataCollection
{
    public function find(int $id): iObject;
    public function findAll();
    public function add(iObject $object): bool;
    public function update(iObject $object): bool;
}
