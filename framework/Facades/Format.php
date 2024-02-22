<?php

namespace Framework\Facades;

class Format
{
    /** Split IBAN in groups of four digits each */
    public static function iban(string $IBAN): string
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

    /** Format the given value to `X.XXX,XX EUR` */
    public static function currency(float $value): string
    {
        return self::decimal($value) . ' ' . setting('currencyUnit');
    }

    /** Format the given value to `X.XXX,XX` */
    public static function decimal(float $value): string
    {
        return number_format($value, 2, ',', '.');
    }

    /** Format the given date to `dd.mm.yyyy` */
    public static function date(string $date): string
    {
        return date("d.m.Y", strtotime($date));
    }
}