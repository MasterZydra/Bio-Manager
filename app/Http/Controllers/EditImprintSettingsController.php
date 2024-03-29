<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Framework\Authentication\Auth;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class EditImprintSettingsController extends BaseController implements ControllerInterface
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
        Setting::findByName($name)->setValue(Http::param($name))->save();
    }
}