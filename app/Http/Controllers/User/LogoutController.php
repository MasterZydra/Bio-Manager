<?php

declare(strict_types = 1);

namespace App\Http\Controllers\User;

use Framework\Facades\Http;

class LogoutController extends \Framework\Routing\BaseController implements \Framework\Routing\ControllerInterface
{
    public function execute(): void
    {
        session_destroy();

        Http::redirect('/');
    }
}
