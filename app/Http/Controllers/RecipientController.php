<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Recipient;
use Framework\Authentication\Auth;
use Framework\Facades\Http;

class RecipientController extends \Framework\Routing\BaseController implements \Framework\Routing\ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.recipient.index', ['recipients' => Recipient::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.recipient.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        Auth::checkRole('Maintainer');

        (new Recipient())
            ->setFromHttpParams(['name', 'street', 'postalCode', 'city'])
            ->setIsLocked(false)
            ->save();

        Http::redirect('recipient');
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.recipient.edit', ['recipient' => Recipient::findById(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        Auth::checkRole('Maintainer');

        Recipient::findById(Http::param('id'))
            ->setFromHttpParams(['name', 'street', 'postalCode', 'city', 'isLocked'])
            ->save();

        Http::redirect('recipient');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Auth::checkRole('Maintainer');

        Recipient::delete(Http::param('id'));

        Http::redirect('recipient');
    }
}
