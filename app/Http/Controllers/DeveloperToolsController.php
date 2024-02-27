<?php

namespace App\Http\Controllers;

use Framework\Authentication\Auth;
use Framework\Facades\DeveloperTools;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class DeveloperToolsController extends BaseController implements ControllerInterface
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

            Http::redirect('/');
        }

        Http::redirect('/');
    }
}