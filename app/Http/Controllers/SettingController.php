<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ModelControllerInterface;

class SettingController extends BaseController implements ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        view('entities.setting.index', ['settings' => Setting::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        view('entities.setting.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        (new Setting())
            ->setName(Http::param('name'))
            ->setDescription(Http::param('description'))
            ->setValue(Http::param('value'))
            ->save();

        Http::redirect('setting');
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        view('entities.setting.edit', ['setting' => Setting::findById(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        Setting::findById(Http::param('id'))
            ->setDescription(Http::param('description'))
            ->setValue(Http::param('value'))
            ->save();

        Http::redirect('setting');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Setting::delete(Http::param('id'));

        Http::redirect('setting');
    }
}
