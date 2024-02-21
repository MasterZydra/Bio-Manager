<?php

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use App\Models\Invoice;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;
use Framework\Facades\Http;
use Framework\PDF\PDF;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class VolumeDistributionPdfController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        if (Http::requestMethod() === 'GET') {
            view('statistics.volumeDistribution');
            return;
        }

        if (Http::requestMethod() === 'POST') {
            if (Http::param('invoiceYear', '') === '') {
                Http::redirect('showSupplierPayouts');
            }

            $filename = 'Mengenverteilung ' . Http::param('invoiceYear');

            (new PDF())
                ->createPDF(setting('invoiceAuthor'), $filename, $filename, render('pdf.volumeDistribution', ['year' => Http::param('invoiceYear')]))
                ->showInBrowser($filename);
            return;
        }

        Http::redirect('/');
    }
}