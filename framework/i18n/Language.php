<?php

namespace Framework\i18n;

class Language
{
    /** Get the two letter language code from the browser */
    public static function getBrowserLanguage(): string
    {
        return strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
    }
}