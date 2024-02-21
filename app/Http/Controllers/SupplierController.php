<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ModelControllerInterface;

class SupplierController extends BaseController implements ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        view('entities.supplier.index', ['suppliers' => Supplier::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        view('entities.supplier.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        (new Supplier())
            ->setFromHttpParam('name')
            ->setIsLocked(false)
            ->setHasFullPayout(false)
            ->setHasNoPayout(false)
            ->save();

        Http::redirect('supplier');
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        view('entities.supplier.edit', ['supplier' => Supplier::findById(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        Supplier::findById(Http::param('id'))
            ->setFromHttpParams(['name', 'isLocked', 'hasFullPayout', 'hasNoPayout'])
            ->save();

        Http::redirect('supplier');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Supplier::delete(Http::param('id'));

        Http::redirect('supplier');
    }
}
