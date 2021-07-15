<?php
/*
* mySQL_helpers.php
* -----------------
* This file contains the class 'MySQL_helpers'.
* The class contains static functions that encapsulate logic
* e.g. to check if a supplier already exists by using the existing
* prepared statements.
*
* @Author: David Hein
*/
include_once 'system/modules/dataObjects/iDataCollection.php'; 

class MySQL_helpers {
    public static function objectAlreadyExists(iDataCollection $collection, string $name, int $id) : bool
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

?>