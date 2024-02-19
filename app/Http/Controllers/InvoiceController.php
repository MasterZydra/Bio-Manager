<?php

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use App\Models\Invoice;
use Framework\Database\Query\SortOrder;
use Framework\Facades\Http;
use Framework\PDF\PDF;
use Framework\Routing\BaseController;
use Framework\Routing\ModelControllerInterface;

class InvoiceController extends BaseController implements ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        view(
            'entities.invoice.index',
            ['invoices' => Invoice::all(
                Invoice::getQueryBuilder()
                    ->orderBy('year', SortOrder::Desc)
                    ->orderBy('nr', SortOrder::Desc)
            )]
        );
    }

    /**
     * Show the details of one model
     * Route: <base route>/show
     */
    public function show(): void
    {
        $invoice = Invoice::findById(Http::param('id'));
        (new PDF())
            ->createPDF(setting('invoiceAuthor'), $invoice->PdfInvoiceName(), $invoice->PdfInvoiceName(), render('pdf.invoice', ['invoice' => $invoice]))
            ->showInBrowser($invoice->PdfInvoiceName());
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        view('entities.invoice.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        $year = Http::param('year');
        $nr = Invoice::nextInvoiceNr(Http::param('year'));

        (new Invoice())
            ->setYear($year)
            ->setNr($nr)
            ->setInvoiceDate(date('Y-m-d'))
            ->setRecipientId(Http::param('recipient'))
            ->setIsPaid(false)
            ->save();
        
        $invoice = Invoice::findByYearAndNr($year, $nr);

        Http::redirect('invoice/edit?id=' . $invoice->getId());
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        view('entities.invoice.edit', ['invoice' => Invoice::findById(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        $invoice = Invoice::findById(Http::param('id'))
            ->setInvoiceDate(Http::param('invoiceDate'))
            ->setRecipientId(Http::param('recipient'))
            ->setIsPaid(Http::param('isPaid'))
            ->save();

        foreach (Http::param('deliveryNote') as $deliveryNoteId) {
            $parts = explode('-', $deliveryNoteId);
            DeliveryNote::findById($parts[0])
                ->setInvoiceId($parts[1] === "1" ? $invoice->getId(): null)
                ->save();
        }

        Http::redirect('invoice');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Invoice::delete(Http::param('id'));

        Http::redirect('invoice');
    }
}
