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
        if (!is_numeric($this->getParam('year'))) {
            Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Year')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric($this->getParam('price'))) {
            Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Price')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric($this->getParam('pricePayout'))) {
            Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Payout')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric($this->getParam('product'))) {
            Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Product')), Type::Error);
            $isValid = false;
        }
        if (!is_numeric($this->getParam('recipient'))) {
            Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Recipient')), Type::Error);
            $isValid = false;
        }
        if (!$isValid) {
            Http::redirect('price/create');
        }

        (new Price())
            ->setYear(intval($this->getParam('year')))
            ->setPrice(floatval($this->getParam('price')))
            ->setPricePayout(floatval($this->getParam('pricePayout')))
            ->setProductId(intval($this->getParam('product')))
            ->setRecipientId(intval($this->getParam('recipient')))
            ->save();

        Http::redirect('price');
    }

    /**
     * Show form to edit one model
     * Route: <base route>/edit
     */
    public function edit(): void
    {
        view('entities.price.edit', ['price' => Price::find($this->getParam('id'))]);
    }

    /**
     * Update one model with the informations from the edit form
     * Route: <base route>/update
     */
    public function update(): void
    {
            // Validate field types
            $isValid = true;
            if (!is_numeric($this->getParam('year'))) {
                Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Year')), Type::Error);
                $isValid = false;
            }
            if (!is_numeric($this->getParam('price'))) {
                Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Price')), Type::Error);
                $isValid = false;
            }
            if (!is_numeric($this->getParam('pricePayout'))) {
                Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Payout')), Type::Error);
                $isValid = false;
            }
            if (!is_numeric($this->getParam('product'))) {
                Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Product')), Type::Error);
                $isValid = false;
            }
            if (!is_numeric($this->getParam('recipient'))) {
                Message::setMessage(sprintf(__('InvalidDataTypeForField'), __('Recipient')), Type::Error);
                $isValid = false;
            }
            if (!$isValid) {
                Http::redirect('price/create?id=' . $this->getParam('id'));
            }
        
            Price::find($this->getParam('id'))
                ->setYear(intval($this->getParam('year')))
                ->setPrice(floatval($this->getParam('price')))
                ->setPricePayout(floatval($this->getParam('pricePayout')))
                ->setProductId(intval($this->getParam('product')))
                ->setRecipientId(intval($this->getParam('recipient')))
                ->save();
        
            Http::redirect('price');
    }

    /**
     * Delete one model
     * Route: <base route>/destroy
     */
    public function destroy(): void
    {
        Price::delete($this->getParam('id'));

        Http::redirect('price');
    }
}
