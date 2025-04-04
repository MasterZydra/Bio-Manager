<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Setting;
use Framework\Authentication\Auth;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class EditInvoiceSettingsController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        Auth::checkRole('Administrator');

        if (Http::requestMethod() === 'GET') {
            view('settings.editInvoice');
            return;
        }
        
        if (Http::requestMethod() === 'POST') {
            $this->settingFromParam('invoiceSenderName');
            $this->settingFromParam('invoiceSenderStreet');
            $this->settingFromParam('invoiceSenderPostalCode');
            $this->settingFromParam('invoiceSenderCity');
            $this->settingFromParam('invoiceSenderAddition');

            $this->settingFromParam('invoiceBankName');
            $this->settingFromParam('invoiceIBAN');
            $this->settingFromParam('invoiceBIC');

            $this->settingFromParam('invoiceAuthor');
            $this->settingFromParam('invoiceName');

            Http::redirect('/');
        }

        Http::redirect('/');
    }

    private function settingFromParam(string $name): void
    {
        Setting::findByName($name)->setValue(Http::param($name))->save();
    }
}