<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
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
        view('entities.user.index', ['users' => User::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        view('entities.user.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        (new User())
            ->setFirstname($this->getParam('firstname'))
            ->setLastname($this->getParam('lastname'))
            ->setUsername($this->getParam('username'))
            ->setPassword($this->getParam('password'))
            ->setIsLocked($this->getParam('isLocked'))
            ->setIsPwdChangeForced($this->getParam('isPwdChangeForced'))
            ->save();

        $user = User::findByUsername($this->getParam('username'));
        echo $user->getId();

        /** @var \App\Models\Role $role */
        foreach (Role::all() as $role) {
            $permission = $this->getParam($role->getName(), '0');
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
        view('entities.user.edit', ['user' => User::find($this->getParam('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        /** @var \App\Models\User */
        $user = User::find($this->getParam('id'))
            ->setFirstname($this->getParam('firstname'))
            ->setLastname($this->getParam('lastname'))
            ->setUsername($this->getParam('username'))
            ->setIsLocked($this->getParam('isLocked'))
            ->setIsPwdChangeForced($this->getParam('isPwdChangeForced'));

        if ($this->getParam('password', '') !== '') {
            $user->setPassword($this->getParam('password'));
        }
        $user->save();

        /** @var \App\Models\Role $role */
        foreach (Role::all() as $role) {
            echo $this->getParam($role->getName(), '0');
            $permission = $this->getParam($role->getName(), '0');
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
        User::delete($this->getParam('id'));

        Http::redirect('user');
    }
}
