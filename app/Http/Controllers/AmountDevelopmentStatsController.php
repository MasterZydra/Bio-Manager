<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Framework\Authentication\Auth;
use Framework\Database\Database;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class AmountDevelopmentStatsController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        Auth::checkRole('Maintainer');

        $dataSet = Database::unprepared('SELECT year, SUM(amount) AS amount FROM deliveryNotes GROUP BY year ORDER BY year ASC');
        $data = [];
        if ($dataSet !== false) {
            while ($row = $dataSet->fetch()) {
                $data[$row['year']] = $row['amount'];
            }
        }

        view('statistics.amountDevelopment', ['data' => $data]);
    }

}
