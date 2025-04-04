<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Framework\Authentication\Auth;
use Framework\Facades\Http;

class EditImprintSettingsController extends \Framework\Routing\BaseController implements \Framework\Routing\ControllerInterface
{
    public function execute(): void
    {
        Auth::checkRole('Administrator');

        if (Http::requestMethod() === 'GET') {
            view('settings.editImprint');
            return;
        }
        
        if (Http::requestMethod() === 'POST') {
            $this->settingFromParam('imprintProviderName');
            $this->settingFromParam('imprintProviderStreet');
            $this->settingFromParam('imprintProviderPostalCode');
            $this->settingFromParam('imprintProviderCity');
            $this->settingFromParam('imprintProviderEmail');

            $this->settingFromParam('imprintResponsibleName');
            $this->settingFromParam('imprintResponsibleStreet');
            $this->settingFromParam('imprintResponsiblePostalCode');
            $this->settingFromParam('imprintResponsibleCity');
            $this->settingFromParam('imprintResponsibleEmail');

            Http::redirect('/');
        }

        Http::redirect('/');
    }

    private function settingFromParam(string $name): void
    {
        \App\Models\Setting::findByName($name)->setValue(Http::param($name))->save();
    }
}