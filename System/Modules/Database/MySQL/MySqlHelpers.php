<?php

/*
* MySqlHelpers.php
* -----------------
* This file contains the class 'MySqlHelpers'.
* The class contains static functions that encapsulate logic
* e.g. to check if a supplier already exists by using the existing
* prepared statements.
*
* @Author: David Hein
*/
include_once 'system/modules/dataObjects/IDataCollection.php';

class MySqlHelpers
{
    public static function objectAlreadyExists(IDataCollection $collection, string $name, int $id): bool
    {
        $objects = $collection->findByName($name);
        if (is_null($objects)) {
            return false;
        }

        foreach ($objects as $object) {
            if ($object->id() != $id) {
                return true;
            }
        }
        return false;
    }
}
