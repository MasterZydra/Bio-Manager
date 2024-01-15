<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ModelControllerInterface;

class RecipientController extends BaseController implements ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        view('entities.recipient.index', ['recipients' => Recipient::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        view('entities.recipient.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        (new Recipient())
            ->setName(Http::param('name'))
            ->setAddress(Http::param('address'))
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
        view('entities.recipient.edit', ['recipient' => Recipient::find(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        Recipient::find(Http::param('id'))
            ->setName(Http::param('name'))
            ->setAddress(Http::param('address'))
            ->setIsLocked(Http::param('isLocked'))
            ->save();

        Http::redirect('recipient');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Recipient::delete(Http::param('id'));

        Http::redirect('recipient');
    }
}
