<?php

declare(strict_types = 1);

namespace App\Http\Controllers\User;

use App\Models\User;
use Framework\Authentication\Auth;
use Framework\Authentication\Session;
use Framework\Facades\Http;
use Framework\Message\Message;
use Framework\Message\Type;

class LoginController extends \Framework\Routing\BaseController implements \Framework\Routing\ControllerInterface
{
    public function execute(): void
    {
        if (Http::requestMethod() !== 'POST') {
            Http::redirect('/');
        }

        $user = User::findByUsername(Http::param('username'));

        if (!Auth::isPasswordValid(Http::param('username'), Http::param('password'))
            || !$user->canLogIn()
        ) {
            Message::setMessage(__('UsernameOrPasswordIsIncorrect'), Type::Error);
            Http::redirect('login');
        }

        Session::setValue('userId', $user->getId());
        Http::redirect('/');
    }
}