<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use App\Models\Invoice;
use Framework\Authentication\Auth;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;
use Framework\Facades\Http;

class SupplierPayoutsController extends \Framework\Routing\BaseController implements \Framework\Routing\ControllerInterface
{
    public function execute(): void
    {
        Auth::checkRole('Maintainer');

        if (Http::requestMethod() === 'GET') {
            view('statistics.supplierPayouts');
            return;
        }

        if (Http::requestMethod() === 'POST') {
            if (Http::param('invoiceId', '') === '' && Http::param('invoiceYear', '') === '') {
                Http::redirect('showSupplierPayouts');
            }

            $invoice = null;
            $filename = 'Auszahlungen_';
            $queryBuilder = DeliveryNote::getQueryBuilder()->orderBy('supplierId')->orderBy('id');

            if (Http::param('invoiceId', '') !== '') {
                $queryBuilder->where(ColType::Int, 'invoiceId', Condition::Equal, Http::param('invoiceId'));
                $invoice = Invoice::findById(Http::param('invoiceId'));
                $filename .= $invoice->getYear() . '_' . $invoice->getNr();
            } elseif (Http::param('invoiceYear', '') !== '') {
                $queryBuilder->where(ColType::Int, 'year', Condition::Equal, Http::param('invoiceYear'));
                $filename .= Http::param('invoiceYear');
            }

            $deliveryNotes = DeliveryNote::all($queryBuilder);

            new \Framework\PDF\PDF()
                ->createPDF(setting('invoiceAuthor'), $filename, $filename, render('pdf.supplierPayouts', ['deliveryNotes' => $deliveryNotes, 'invoice' => $invoice]))
                ->showInBrowser($filename);
            return;
        }

        Http::redirect('/');
    }
}