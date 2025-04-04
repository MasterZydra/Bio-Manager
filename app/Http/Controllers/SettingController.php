<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Setting;
use Framework\Authentication\Auth;
use Framework\Facades\Http;

class SettingController extends \Framework\Routing\BaseController implements \Framework\Routing\ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        Auth::checkRole('Administrator');

        view('entities.setting.index', ['settings' => Setting::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        Auth::checkRole('Administrator');

        view('entities.setting.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        Auth::checkRole('Administrator');

        (new Setting())
            ->setFromHttpParams(['name', 'description', 'value'])
            ->save();

        Http::redirect('setting');
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        Auth::checkRole('Administrator');

        view('entities.setting.edit', ['setting' => Setting::findById(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        Auth::checkRole('Administrator');

        Setting::findById(Http::param('id'))
            ->setFromHttpParams(['description', 'value'])
            ->save();

        Http::redirect('setting');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Auth::checkRole('Administrator');

        Setting::delete(Http::param('id'));

        Http::redirect('setting');
    }
}
