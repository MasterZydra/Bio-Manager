<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Framework\Authentication\Auth;
use Framework\Facades\Http;

class VolumeDistributionPdfController extends \Framework\Routing\BaseController implements \Framework\Routing\ControllerInterface
{
    public function execute(): void
    {
        Auth::checkRole('Maintainer');

        if (Http::requestMethod() === 'GET') {
            view('statistics.volumeDistribution');
            return;
        }

        if (Http::requestMethod() === 'POST') {
            if (Http::param('invoiceYear', '') === '') {
                Http::redirect('showSupplierPayouts');
            }

            $filename = 'Mengenverteilung ' . Http::param('invoiceYear');

            new \Framework\PDF\PDF()
                ->createPDF(setting('invoiceAuthor'), $filename, $filename, render('pdf.volumeDistribution', ['year' => Http::param('invoiceYear')]))
                ->showInBrowser($filename);
            return;
        }

        Http::redirect('/');
    }
}