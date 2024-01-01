<?php

namespace App\Http\Controllers;

use App\Models\User;
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
     * Show the details of one model
     * Route: <base route>/show
     */
    public function show(): void
    {
        view('entities.user.show', ['user' => User::find($this->getParam('id'))]);
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
