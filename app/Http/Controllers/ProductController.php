<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        view('entities.product.index', ['products' => Product::all()]);
    }

    /**
     * Show the details of one model
     * Route: <base route>/show
     */
    public function show(): void
    {
        view('entities.product.show', ['product' => Product::loadById($this->getParam('id'))]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        view('entities.product.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        $product = new Product(null, $this->getParam('name'), false);
        $product->save();

        $this->redirect('product');
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        view('entities.product.edit', ['product' => Product::loadById($this->getParam('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        Product::loadById($this->getParam('id'))
            ->setName($this->getParam('name'))
            ->setIsDiscontinued($this->getParam('isDiscontinued'))
            ->save();

        $this->redirect('product');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Product::loadById($this->getParam('id'))->delete();

        $this->redirect('product');
    }
}