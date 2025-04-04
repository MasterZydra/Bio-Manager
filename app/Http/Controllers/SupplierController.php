<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Supplier;
use Framework\Authentication\Auth;
use Framework\Facades\Http;

class SupplierController extends \Framework\Routing\BaseController implements \Framework\Routing\ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.supplier.index', ['suppliers' => Supplier::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.supplier.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        Auth::checkRole('Maintainer');

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
        Auth::checkRole('Maintainer');

        view('entities.supplier.edit', ['supplier' => Supplier::findById(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        Auth::checkRole('Maintainer');

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
        Auth::checkRole('Maintainer');

        Supplier::delete(Http::param('id'));

        Http::redirect('supplier');
    }
}
