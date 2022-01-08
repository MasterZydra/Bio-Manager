<?php

/*
* iObject.php
* ----------------
* This file contains the interface 'iObject'.
* The interface has to be implemented if a class shall be used in an
* iDataCollection or shall be displayed with the TableGenerator class.
*
* @Author: David Hein
*/
interface iObject
{
    public function id(): int;
    public function toArray(): array;
}
