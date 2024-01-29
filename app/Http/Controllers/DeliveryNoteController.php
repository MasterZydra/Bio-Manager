<?php

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ModelControllerInterface;

class DeliveryNoteController extends BaseController implements ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        view('entities.deliveryNote.index', ['deliveryNotes' => DeliveryNote::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        view('entities.deliveryNote.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        (new DeliveryNote())
            ->setYear(Http::param('year'))
            ->setNr(DeliveryNote::nextDeliveryNoteNr(Http::param('year')))
            ->setDeliveryDate(date('Y-m-d'))
            ->setAmount(null)
            ->setProductId(Http::param('product'))
            ->setSupplierId(Http::param('supplier'))
            ->setRecipientId(Http::param('recipient'))
            ->setInvoiceId(null)
            ->setIsInvoiceReady(false)
            ->save();

        Http::redirect('deliveryNote');
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        view('entities.deliveryNote.edit', ['deliveryNote' => DeliveryNote::findById(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        DeliveryNote::findById(Http::param('id'))
            ->setDeliveryDate(Http::param('deliveryDate'))
            ->setAmount(Http::param('amount'))
            ->setProductId(Http::param('product'))
            ->setSupplierId(Http::param('supplier'))
            ->setRecipientId(Http::param('recipient'))
            ->setIsInvoiceReady(Http::param('isInvoiceReady'))
            ->save();

        Http::redirect('deliveryNote');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        DeliveryNote::delete(Http::param('id'));

        Http::redirect('deliveryNote');
    }
}
