<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use Framework\Authentication\Auth;
use Framework\Facades\Http;

class DeliveryNoteController extends \Framework\Routing\BaseController implements \Framework\Routing\ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.deliveryNote.index', ['deliveryNotes' => DeliveryNote::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.deliveryNote.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        Auth::checkRole('Maintainer');

        new DeliveryNote()
            ->setFromHttpParams(['year', 'productId', 'supplierId', 'recipientId'])
            ->setNr(DeliveryNote::nextDeliveryNoteNr(intval(Http::param('year'))))
            ->setDeliveryDate(date('Y-m-d'))
            ->setAmount(null)
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
        Auth::checkRole('Maintainer');

        view('entities.deliveryNote.edit', ['deliveryNote' => DeliveryNote::findById(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        Auth::checkRole('Maintainer');

        DeliveryNote::findById(Http::param('id'))
            ->setFromHttpParams(['deliveryDate', 'amount', 'productId', 'supplierId', 'recipientId', 'isInvoiceReady'])
            ->save();

        Http::redirect('deliveryNote');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Auth::checkRole('Maintainer');

        DeliveryNote::delete(Http::param('id'));

        Http::redirect('deliveryNote');
    }
}
