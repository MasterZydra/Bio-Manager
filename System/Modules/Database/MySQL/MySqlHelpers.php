<?php

namespace System\Modules\Database\MySQL;

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

class MySqlHelpers
{
    public static function objectAlreadyExists(
        \System\Modules\DataObjects\IDataCollection $collection,
        string $name,
        int $id
    ): bool {
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
