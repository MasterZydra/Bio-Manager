<?php

namespace App\Http\Controllers;

use Framework\Authentication\Auth;
use Framework\Database\Database;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class LoginController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        if ($this->getRequestMethod() === 'POST') {
            // TODO check if method is post -> else deny
        }

        Database::prepared(
            'SELECT `password` FROM users WHERE username = ?',
            's',
            $this->getParam('user_login')
        );
        
        // TODO check password
        $_SESSION['userId'] = 123; // TODO use user id
        Http::redirect('/');
    }
}