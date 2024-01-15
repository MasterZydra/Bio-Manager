<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Framework\Facades\Http;
use Framework\Message\Message;
use Framework\Message\Type;
use Framework\Routing\BaseController;
use Framework\Routing\ModelControllerInterface;

class PriceController extends BaseController implements ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        view('entities.price.index', ['prices' => Price::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        view('entities.price.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        // Validate field types
        $isValid = true;
        if (!is_numeric(Http::param('year'))) {
            Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Year')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric(Http::param('price'))) {
            Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Price')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric(Http::param('pricePayout'))) {
            Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Payout')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric(Http::param('product'))) {
            Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Product')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric(Http::param('recipient'))) {
            Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Recipient')), Type::Error);
            $isValid = false;
        }
        if (!$isValid) {
            Http::redirect('price/create');
        }

        (new Price())
            ->setYear(intval(Http::param('year')))
            ->setPrice(floatval(Http::param('price')))
            ->setPricePayout(floatval(Http::param('pricePayout')))
            ->setProductId(intval(Http::param('product')))
            ->setRecipientId(intval(Http::param('recipient')))
            ->save();

        Http::redirect('price');
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        view('entities.price.edit', ['price' => Price::find(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
            // Validate field types
            $isValid = true;
            if (!is_numeric(Http::param('year'))) {
                Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Year')), Type::Error);
                $isValid = false;
            }
            if (!is_numeric(Http::param('price'))) {
                Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Price')), Type::Error);
                $isValid = false;
            }
            if (!is_numeric(Http::param('pricePayout'))) {
                Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Payout')), Type::Error);
                $isValid = false;
            }
            if (!is_numeric(Http::param('product'))) {
                Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Product')), Type::Error);
                $isValid = false;
            }
            if (!is_numeric(Http::param('recipient'))) {
                Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Recipient')), Type::Error);
                $isValid = false;
            }
            if (!$isValid) {
                Http::redirect('price/create?id=' . Http::param('id'));
            }
        
            Price::find(Http::param('id'))
                ->setYear(intval(Http::param('year')))
                ->setPrice(floatval(Http::param('price')))
                ->setPricePayout(floatval(Http::param('pricePayout')))
                ->setProductId(intval(Http::param('product')))
                ->setRecipientId(intval(Http::param('recipient')))
                ->save();
        
            Http::redirect('price');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Price::delete(Http::param('id'));

        Http::redirect('price');
    }
}
