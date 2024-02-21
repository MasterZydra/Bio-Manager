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

class SupplierPayoutsController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
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

            (new PDF())
                ->createPDF(setting('invoiceAuthor'), $filename, $filename, render('pdf.supplierPayouts', ['deliveryNotes' => $deliveryNotes, 'invoice' => $invoice]))
                ->showInBrowser($filename);
            return;
        }

        Http::redirect('/');

    }
}