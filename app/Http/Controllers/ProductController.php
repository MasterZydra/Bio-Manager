<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Framework\Authentication\Auth;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ModelControllerInterface;

class ProductController extends BaseController implements ModelControllerInterface
{
    /** 
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.product.index', ['products' => Product::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.product.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        Auth::checkRole('Maintainer');

        (new Product())
            ->setFromHttpParam('name')
            ->setIsDiscontinued(false)
            ->save();

        Http::redirect('product');
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.product.edit', ['product' => Product::findById(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        Auth::checkRole('Maintainer');

        Product::findById(Http::param('id'))
            ->setFromHttpParams(['name', 'isDiscontinued'])
            ->save();

        Http::redirect('product');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Auth::checkRole('Maintainer');

        Product::delete(Http::param('id'));

        Http::redirect('product');
    }
}