<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Price;
use Framework\Authentication\Auth;
use Framework\Facades\Http;
use Framework\Message\Message;
use Framework\Message\Type;

class PriceController extends \Framework\Routing\BaseController implements \Framework\Routing\ModelControllerInterface
{
    /**
     * Show list of all models
     * Route: <base route>
     */
    public function index(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.price.index', ['prices' => Price::all()]);
    }

    /**
     * Show form to create one model
     * Route: <base route>/create
     */
    public function create(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.price.create');
    }

    /**
     * Create a new model with the informations from the create form
     * Route: <base route>/store
     */
    public function store(): void
    {
        Auth::checkRole('Maintainer');

        // Validate field types
        $isValid = true;
        if (!is_numeric(Http::param('year'))) {
            Message::setMessage(__('InvalidDataTypeForField', __('Year')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric(Http::param('price'))) {
            Message::setMessage(__('InvalidDataTypeForField', __('Price')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric(Http::param('pricePayout'))) {
            Message::setMessage(__('InvalidDataTypeForField', __('Payout')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric(Http::param('productId'))) {
            Message::setMessage(__('InvalidDataTypeForField', __('Product')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric(Http::param('recipientId'))) {
            Message::setMessage(__('InvalidDataTypeForField', __('Recipient')), Type::Error);
            $isValid = false;
        }
        if (!$isValid) {
            Http::redirect('price/create');
        }

        new Price()
            ->setYear(intval(Http::param('year')))
            ->setPrice(floatval(Http::param('price')))
            ->setPricePayout(floatval(Http::param('pricePayout')))
            ->setProductId(intval(Http::param('productId')))
            ->setRecipientId(intval(Http::param('recipientId')))
            ->save();

        Http::redirect('price');
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        Auth::checkRole('Maintainer');

        view('entities.price.edit', ['price' => Price::findById(Http::param('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
        Auth::checkRole('Maintainer');

        // Validate field types
        $isValid = true;
        if (!is_numeric(Http::param('year'))) {
            Message::setMessage(__('InvalidDataTypeForField', __('Year')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric(Http::param('price'))) {
            Message::setMessage(__('InvalidDataTypeForField', __('Price')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric(Http::param('pricePayout'))) {
            Message::setMessage(__('InvalidDataTypeForField', __('Payout')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric(Http::param('productId'))) {
            Message::setMessage(__('InvalidDataTypeForField', __('Product')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric(Http::param('recipientId'))) {
            Message::setMessage(__('InvalidDataTypeForField', __('Recipient')), Type::Error);
            $isValid = false;
        }
        if (!$isValid) {
            Http::redirect('price/create?id=' . Http::param('id'));
        }
    
        Price::findById(Http::param('id'))
            ->setYear(intval(Http::param('year')))
            ->setPrice(floatval(Http::param('price')))
            ->setPricePayout(floatval(Http::param('pricePayout')))
            ->setProductId(intval(Http::param('productId')))
            ->setRecipientId(intval(Http::param('recipientId')))
            ->save();
    
        Http::redirect('price');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Auth::checkRole('Maintainer');

        Price::delete(Http::param('id'));

        Http::redirect('price');
    }
}
