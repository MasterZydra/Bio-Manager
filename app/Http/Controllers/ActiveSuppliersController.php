<?php

namespace App\Http\Controllers;

use Framework\Facades\Http;
use Framework\PDF\PDF;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class ActiveSuppliersController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        if (Http::requestMethod() !== 'GET') {
            Http::redirect('/');
            return;
        }

        (new PDF())
            ->createPDF(setting('invoiceAuthor'), 'Aktive_Lieferanten', 'Aktive_Lieferanten', render('pdf.activeSuppliers'))
            ->showInBrowser('Aktive_Lieferanten_' . date('Y_m_d'));
    }
}