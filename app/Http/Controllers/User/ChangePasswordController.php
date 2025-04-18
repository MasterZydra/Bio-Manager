<?php

declare(strict_types = 1);

namespace App\Http\Controllers\User;

use App\Models\User;
use Framework\Authentication\Auth;
use Framework\Facades\Http;
use Framework\Message\Message;
use Framework\Message\Type;

class ChangePasswordController extends \Framework\Routing\BaseController implements \Framework\Routing\ControllerInterface
{
    public function execute(): void
    {
        if (Http::requestMethod() !== 'POST') {
            Http::redirect('/');
        }

        /** @var User $user */
        $user = User::findById(Auth::id());

        // Check if the given old password is valid
        if (!Auth::isPasswordValid($user->getUsername(), Http::param('oldPassword'))) {
            Message::setMessage(__('PasswordIsIncorrect'), Type::Error);
            Http::redirect('changePassword');
        }

        // Check if the new password and the password confirmation are equl
        if (Http::param('newPassword') !== Http::param('confirmedPassword')) {
            Message::setMessage(__('NewPasswordsAreUnequal'), Type::Error);
            Http::redirect('changePassword');
        }

        $user->setPassword(Http::param('newPassword'))->save();

        Message::setMessage(__('PasswordChangedSuccessfully'), Type::Success);
        Http::redirect('/');
    }
}