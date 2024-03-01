<?php

/** @var array $deliveryNotes */

use App\Models\DeliveryNote;
use App\Models\Supplier;
use Framework\Facades\Format;

/** @var ?\App\Models\Invoice $invoice */

$docName = '';
if (isset($invoice)) {
    $docName = 'Auszahlung für Rechnung ' . $invoice->getYear() . ' ' . $invoice->getNr();
} else {
    $docName = 'Auszahlung für das Jahr ' . $deliveryNotes[0]->getYear();
}

$lastSupplier = null;
$GLOBALS['sumAmount'] = 0;
$GLOBALS['sumPayout'] = 0;

function printSum()
{ ?>
        <tr style="height:2px;"><td style="height:2px;" colspan="4"><hr></td></tr>
        <tr>
            <td></td>
            <td style="text-align: right;">Summe:</td>
            <td style="text-align: right;"><?= $GLOBALS['sumAmount'] ?></td>
            <td style="text-align: right;"><?= Format::currency($GLOBALS['sumPayout']) ?></td>
        </tr>
    </table><br><br>
<?php
}

function printSupplierHeader(Supplier $supplier)
{ ?>
    <i><?= $supplier->getName() ?></i><br>
    <table>
        <tr>
            <th style="text-align: center;"><strong>Lieferschein-Nr.</strong></th>
            <th style="text-align: center;"><strong>Lieferdatum</strong></th>
            <th style="text-align: center;"><strong>Menge in <?= setting('massUnit')?></strong></th>
            <th style="text-align: center;"><strong>x Preis in <?= setting('currencyUnit') ?></strong></th>
        </tr>
<?php
}

function printDeliveryNoteLine(DeliveryNote $deliveryNote)
{
    $price = $deliveryNote->getSupplier()->getHasFullPayout() ?
    $deliveryNote->getPrice()->getPrice() : $deliveryNote->getPrice()->getPricePayout();
    $GLOBALS['sumAmount'] += $deliveryNote->getAmount();
    $GLOBALS['sumPayout'] += $price * $deliveryNote->getAmount();
?>
    <tr>
        <td style="text-align: right;"><?= $deliveryNote->getNr() ?></td>
        <td style="text-align: center;"><?= Format::date($deliveryNote->getDeliveryDate()) ?></td>
        <td style="text-align: right;"><?= $deliveryNote->getAmount() ?></td>
        <td style="text-align: right;">x <?= $price ?> = <?= Format::currency($price * $deliveryNote->getAmount()) ?></td>
    </tr>
<?php
}
?>

<table cellpadding="5" cellspacing="0" style="width: 100%; ">
    <tr>
        <td width="100%">
            <h1 style="text-align: center;"><?= $docName ?></h1><br>

            <?php
                /** @var \App\Models\DeliveryNote $deliveryNote */
                foreach ($deliveryNotes as $deliveryNote) {
                    if ($deliveryNote->getSupplier()->getHasNoPayout()) {
                        continue;
                    }

                    if ($deliveryNote->getSupplier()->getId() !== $lastSupplier) {
                        if ($lastSupplier !== null) {
                            printSum();
                        }

                        $lastSupplier = $deliveryNote->getSupplier()->getId();
                        $GLOBALS['sumAmount'] = 0;
                        $GLOBALS['sumPayout'] = 0;

                        printSupplierHeader($deliveryNote->getSupplier());
                    }

                    printDeliveryNoteLine($deliveryNote);
                }
                printSum();
            ?>
        </td>
    </tr>
</table>
