<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ModelControllerInterface;

class PlotController extends BaseController implements ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        view('entities.plot.index', ['plots' => Plot::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        view('entities.plot.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        (new Plot())
            ->setNr(Http::param('nr'))
            ->setName(Http::param('name'))
            ->setSubdistrict(Http::param('subdistrict'))
            ->setSupplierId(Http::param('supplier'))
            ->setIsLocked(false)
            ->save();

        Http::redirect('plot');
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        view('entities.plot.edit', ['plot' => Plot::find(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        Plot::find(Http::param('id'))
            ->setNr(Http::param('nr'))
            ->setName(Http::param('name'))
            ->setSubdistrict(Http::param('subdistrict'))
            ->setSupplierId(Http::param('supplier'))
            ->setIsLocked(Http::param('isLocked'))
            ->save();
        
        Http::redirect('plot');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Plot::delete(Http::param('id'));

        Http::redirect('plot');
    }
}
