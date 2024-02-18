<?php

namespace Framework\i18n;

use App\Models\User;
use Framework\Authentication\Auth;

class Language
{
    /** Get the two letter language code from the browser */
    public static function getBrowserLanguage(): string
    {
        return strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
    }

    /** Get the language from the browser or from the user settings */
    public static function getLanguage(): string
    {
        if (Auth::isLoggedIn()) {
            $user = User::findById(Auth::id());
            if ($user->getLanguageId() !== null) {
                return $user->getLanguage()->getCode();
            }
        }

        return self::getBrowserLanguage();
    }
}