<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use App\Models\Invoice;
use Framework\Authentication\Auth;
use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;
use Framework\Database\Query\QueryBuilder;

class FinancialRevenueProfitStatsController extends \Framework\Routing\BaseController implements \Framework\Routing\ControllerInterface
{
    public function execute(): void
    {
        Auth::checkRole('Maintainer');

        $dataSet = Database::executeBuilder(QueryBuilder::new('invoices')->select('DISTINCT year'));
        $years = [];
        if ($dataSet !== false) {
            while ($row = $dataSet->fetch()) {
                $years[] = intval($row['year']);
            }
        }

        $data = [];
        foreach ($years as $year) {
            $data[$year] = $this->calculate($year);
        }

        view('statistics.revenueAndProfit', ['data' => $data]);
    }

    private function calculate(int $year): array
    {
        $invoices = Invoice::all(Invoice::getQueryBuilder()
            ->where(ColType::Int, 'year', Condition::Equal, $year)
            ->where(ColType::Int, 'isPaid', Condition::Equal, 1)
        );

        $invoiceIds = array_map(fn(Invoice $invoice): int => $invoice->getId(), $invoices);

        $deliveryNotes = [];
        if (count($invoiceIds) > 0) {
            // TODO Where IN -> if array is empty, some condition that is always false?
            $deliveryNotes = DeliveryNote::all(
                DeliveryNote::getQueryBuilder()->where(ColType::Int, 'invoiceId', Condition::In, $invoiceIds)
            );
        }

        $revenue = 0.0;
        $payouts = 0.0;
        /** @var \App\Models\DeliveryNote $deliveryNote */
        foreach ($deliveryNotes as $deliveryNote) {
            $revenue += $deliveryNote->getPrice()->getPrice() * $deliveryNote->getAmount();

            if ($deliveryNote->getSupplier()->getHasFullPayout()) {
                $payouts += $deliveryNote->getPrice()->getPrice() * $deliveryNote->getAmount();
            } elseif (!$deliveryNote->getSupplier()->getHasNoPayout()) {
                $payouts += $deliveryNote->getPrice()->getPricePayout() * $deliveryNote->getAmount();
            }
        }

        $profit = $revenue - $payouts;

        return ['revenue' => $revenue, 'payouts' => $payouts, 'profit' => $profit];
    }
}
