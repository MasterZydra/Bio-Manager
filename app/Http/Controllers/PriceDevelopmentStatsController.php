<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Price;
use Framework\Authentication\Auth;

class PriceDevelopmentStatsController extends \Framework\Routing\BaseController implements \Framework\Routing\ControllerInterface
{
    public function execute(): void
    {
        Auth::checkRole('Maintainer');

        $prices = Price::all(Price::getQueryBuilder()->orderBy('productId')->orderBy('recipientId')->orderBy('year'));

        $dataPrice = [];
        $dataPricePayout = [];
        /** @var \App\Models\Price $price */
        foreach ($prices as $price) {
            $productName = $price->getProduct()->getName() . ' - ' . $price->getRecipient()->getName();

            if (!key_exists($productName, $dataPrice)) {
                $dataPrice[$productName] = [];
            }
            $dataPrice[$productName][$price->getYear()] = $price->getPrice();

            if (!key_exists($productName, $dataPricePayout)) {
                $dataPricePayout[$productName] = [];
            }
            $dataPricePayout[$productName][$price->getYear()] = $price->getPricePayout();
        }

        view('statistics.priceDevelopment', ['dataPrice' => $dataPrice, 'dataPricePayout' => $dataPricePayout]);
    }

}
