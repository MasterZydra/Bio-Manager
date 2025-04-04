<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Framework\Authentication\Auth;
use Framework\Facades\DeveloperTools;
use Framework\Facades\Http;

class DeveloperToolsController extends \Framework\Routing\BaseController implements \Framework\Routing\ControllerInterface
{
    public function execute(): void
    {
        Auth::checkRole('Developer');

        if (Http::requestMethod() === 'GET') {
            view('settings.devTools');
            return;
        }

        if (Http::requestMethod() === 'POST') {
            DeveloperTools::setShowErrorMessages(Http::param('showErrorMessages') === '1');
            DeveloperTools::setShowSqlQueries(Http::param('showSqlQueries') === '1');

            Http::redirect('/');
        }

        Http::redirect('/');
    }
}