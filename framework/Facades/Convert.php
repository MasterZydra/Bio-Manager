<?php

namespace Framework\Facades;

class Convert
{
    /** Converts the given bool to 0 or 1 */
    public static function boolToInt(bool $value): int
    {
        return $value ? 1 : 0;
    }

    /** Converts the given bool to the translated 'Yes' or 'No' */
    public static function boolToTString(bool $value): string
    {
        return $value ? __('Yes') : __('No');
    }
}