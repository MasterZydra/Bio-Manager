<?php

namespace Framework\Facades;

class Format
{
    /** Split IBAN in groups of four digits each */
    public static function IBAN(string $IBAN): string
    {
        $i = 0;
        $ret = "";
        $len = strlen($IBAN);
        while ($len - $i > 4) {
            $ret .= substr($IBAN, $i, 4);
            $ret .= " ";
            $i += 4;
        }
        $ret .= substr($IBAN, $i);
        return $ret;
    }

    /** Format the given value to e.g. `X.XXX,XX EUR` */
    public static function Currency(float $value): string
    {
        return number_format($value, 2, ',', '.') . ' ' . setting('currencyUnit');
    }
}