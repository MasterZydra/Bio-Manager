<?php

namespace App\Http\Controllers;

use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class LogoutController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        session_destroy();

        Http::redirect('/');
    }
}
