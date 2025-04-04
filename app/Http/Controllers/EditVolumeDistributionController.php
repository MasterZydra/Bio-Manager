<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use App\Models\VolumeDistribution;
use Framework\Authentication\Auth;
use Framework\Facades\Http;
use Framework\Message\Message;
use Framework\Message\Type;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class EditVolumeDistributionController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        Auth::checkRole('Maintainer');

        if (Http::requestMethod() === 'GET') {
            view('entities.volumeDistribution.edit', [
                'deliveryNote' => DeliveryNote::findById(Http::param('id')),
                'distributions' => VolumeDistribution::allByDeliveryNoteId(Http::param('id'))
            ]);
            return;
        }
        
        if (Http::requestMethod() === 'POST') {
            $plots = Http::param('plot');
            $amounts = Http::param('amount');

            if (count($plots) !== count($amounts)) {
                Message::setMessage(__('InvalidVolumeDistributionData'), Type::Error);
                Http::redirect('/deliveryNote');
                return;
            }

            // Remove all distributions
            $distributions = VolumeDistribution::allByDeliveryNoteId(Http::param('id'));
            /** @var \App\Models\VolumeDistribution $distribution */
            foreach ($distributions as $distribution) {
                VolumeDistribution::delete($distribution->getId());
            }

            // Create the new distributions
            for ($i=0; $i < count($plots); $i++) {
                (new VolumeDistribution())
                    ->setDeliveryNoteId(Http::param('id'))
                    ->setPlotId($plots[$i])
                    ->setAmount($amounts[$i])
                    ->save();
            }
            // TODO Improve: Check if already exists -> yes: Remove from list
            // Remove all remaining in list, after updating/inserting the new ones
        }

        Http::redirect('/deliveryNote');
    }
}