<?php

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use Framework\Authentication\Auth;
use Framework\Database\Database;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class OpenVolumeDistributionsController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        Auth::checkRole('Maintainer');

        if (Http::requestMethod() !== 'GET') {
            Http::redirect('/');
        }

        $sql = 'SELECT deliveryNotes.id, SUM(volumeDistributions.amount) as calcSum, deliveryNotes.amount
        FROM deliveryNotes
        LEFT JOIN volumeDistributions ON deliveryNotes.id = volumeDistributions.deliveryNoteId
        GROUP BY deliveryNotes.id
        HAVING calcSum IS NULL OR calcSum != amount;';

        $dataSet = Database::unprepared($sql);

        $deliveryNotes = [];
        if ($dataSet !== false) {
            while ($row = $dataSet->fetch_assoc()) {
                $deliveryNote = DeliveryNote::findById($row['id']);
                $deliveryNote->setCalcSum($row['calcSum']);
                $deliveryNotes[] = $deliveryNote;
            }
        }

        view('statistics.openVolumeDistributions', ['deliveryNotes' => $deliveryNotes]);
    }
}