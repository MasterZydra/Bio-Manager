<?php

namespace App\Http\Controllers;

use App\Models\User;
use Framework\Authentication\Auth;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class LoginController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        if ($this->getRequestMethod() !== 'POST') {
            // TODO check if method is post -> else deny
            Http::redirect('/');
        }

        if (!Auth::isPasswordValid($this->getParam('username'), $this->getParam('password'))) {
            // TODO Message that username or password is invalid
            Http::redirect('/');
        }

        $_SESSION['userId'] = User::findByUsername($this->getParam('username'))->getId();
        Http::redirect('/');
    }
}