<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Framework\Authentication\Auth;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ModelControllerInterface;

class UserController extends BaseController implements ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        Auth::checkRole('Administrator');

        view('entities.user.index', ['users' => User::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        Auth::checkRole('Administrator');

        view('entities.user.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        Auth::checkRole('Administrator');

        (new User())
            ->setFromHttpParams(['firstname', 'lastname', 'username', 'password', 'isLocked', 'isPwdChangeForced'])
            ->setLanguageId(Http::param('languageId') === '' ? null : Http::param('languageId'))
            ->save();

        $user = User::findByUsername(Http::param('username'));
        echo $user->getId();

        /** @var \App\Models\Role $role */
        foreach (Role::all() as $role) {
            $permission = Http::param($role->getName(), '0');
            $userRole = UserRole::findByUserAndRoleId($user->getId(), $role->getId());
            if ($permission === '0') {
                if ($userRole->getId() !== null) {
                    UserRole::delete($userRole->getId());
                }
                continue;
            }
            $userRole
                ->setUserId($user->getId())
                ->setRoleId($role->getId())
                ->save();
        }

        Http::redirect('user');
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        Auth::checkRole('Administrator');

        view('entities.user.edit', ['user' => User::findById(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        Auth::checkRole('Administrator');

        /** @var \App\Models\User */
        $user = User::findById(Http::param('id'))
            ->setFromHttpParams(['firstname', 'lastname', 'username', 'isLocked', 'isPwdChangeForced'])
            ->setLanguageId(Http::param('languageId') === '' ? null : Http::param('languageId'));

        if (Http::param('password', '') !== '') {
            $user->setPassword(Http::param('password'));
        }
        $user->save();

        /** @var \App\Models\Role $role */
        foreach (Role::all() as $role) {
            $permission = Http::param($role->getName(), '0');
            $userRole = UserRole::findByUserAndRoleId($user->getId(), $role->getId());
            if ($permission === '0') {
                if ($userRole->getId() !== null) {
                    UserRole::delete($userRole->getId());
                }
                continue;
            }
            $userRole
                ->setUserId($user->getId())
                ->setRoleId($role->getId())
                ->save();
        }

        Http::redirect('user');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Auth::checkRole('Administrator');

        User::delete(Http::param('id'));

        Http::redirect('user');
    }
}
