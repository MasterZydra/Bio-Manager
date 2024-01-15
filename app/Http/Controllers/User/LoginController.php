<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Framework\Authentication\Auth;
use Framework\Authentication\Session;
use Framework\Facades\Http;
use Framework\Message\Message;
use Framework\Message\Type;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class LoginController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        if (Http::requestMethod() !== 'POST') {
            Http::redirect('/');
        }

        if (!Auth::isPasswordValid(Http::param('username'), Http::param('password'))) {
            Message::setMessage(__('UsernameOrPasswordIsIncorrect'), Type::Error);
            Http::redirect('login');
        }

        Session::setValue('userId', User::findByUsername(Http::param('username'))->getId());
        Http::redirect('/');
    }
}