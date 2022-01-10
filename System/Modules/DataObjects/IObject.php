<?php

/*
* IObject.php
* ----------------
* This file contains the interface 'IObject'.
* The interface has to be implemented if a class shall be used in an
* IDataCollection or shall be displayed with the TableGenerator class.
*
* @Author: David Hein
*/
interface IObject
{
    public function id(): int;
    public function toArray(): array;
}
