<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Framework\Authentication\Auth;
use Framework\Facades\Http;
use Framework\Message\Message;
use Framework\Message\Type;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class ChangePasswordController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        if ($this->getRequestMethod() !== 'POST') {
            // TODO check if method is post -> else deny
            Http::redirect('/');
        }

        /** @var User $user */
        $user = User::find(Auth::id());

        // Check if the given old password is valid
        if (!Auth::isPasswordValid($user->getUsername(), $this->getParam('oldPassword'))) {
            Message::setMessage(__('PasswordIsIncorrect'), Type::Error);
            Http::redirect('changePassword');
        }

        // Check if the new password and the password confirmation are equl
        if ($this->getParam('newPassword') !== $this->getParam('confirmedPassword')) {
            Message::setMessage(__('NewPasswordsAreUnequal'), Type::Error);
            Http::redirect('changePassword');
        }

        $user->setPassword($this->getParam('newPassword'))->save();

        Message::setMessage(__('PasswordChangedSuccessfully'), Type::Success);
        Http::redirect('/');
    }
}