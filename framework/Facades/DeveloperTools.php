<?php

namespace Framework\Facades;

use Framework\Authentication\Auth;
use Framework\Authentication\Session;

class DeveloperTools
{
    public static function showErrorMessages(): bool
    {
        if (!Auth::hasRole('Developer')) {
            return false;
        }

        return Session::getValue('showErrorMessages') === 'true';
    }

    public static function setShowErrorMessages(bool $value): void
    {
        if (!Auth::hasRole('Developer')) {
            return;
        }

        if ($value) {
            Session::setValue('showErrorMessages', 'true');
        } else {
            Session::setValue('showErrorMessages', null);
        }
    }
}