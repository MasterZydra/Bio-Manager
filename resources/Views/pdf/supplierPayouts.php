<?php

/** @var array $deliveryNotes */

use Framework\Facades\Format;

/** @var ?\App\Models\Invoice $invoice */

$docName = '';
if (isset($invoice)) {
    $docName = 'Auszahlung für Rechnung ' . $invoice->getYear() . ' ' . $invoice->getNr();
} else {
    $docName = 'Auszahlung für das Jahr ' . $deliveryNotes[0]->getYear();
}

?>

<table cellpadding="5" cellspacing="0" style="width: 100%; ">

<tr><td width="100%">
<h1 style="text-align: center;"><?= $docName ?></h1><br>

<?php
$lastSupplier = null;
$sumAmount = 0;
$sumPayout = 0;
/** @var \App\Models\DeliveryNote $deliveryNote */
foreach ($deliveryNotes as $deliveryNote) {
    if ($deliveryNote->getSupplier()->getHasNoPayout()) continue;
    if ($deliveryNote->getSupplier()->getId() !== $lastSupplier) {
        if ($lastSupplier !== null) { ?>

<tr style="height:2px;"><td style="height:2px;" colspan="4"><hr></td></tr>
<tr>
    <td></td>
    <td style="text-align: right;">Summe:</td>
    <td style="text-align: right;"><?= $sumAmount ?></td>
    <td style="text-align: right;"><?= Format::Currency($sumPayout) ?></td>
</tr>
</table><br><br>

<?php }
        $lastSupplier = $deliveryNote->getSupplier()->getId();
        $sumAmount = 0;
        $sumPayout = 0;
?>

<i><?= $deliveryNote->getSupplier()->getName() ?></i><br>
<table>
<tr>
    <th style="text-align: center;"><strong>Lieferschein-Nr.</strong></th>
    <th style="text-align: center;"><strong>Lieferdatum</strong></th>
    <th style="text-align: center;"><strong>Menge in <?= setting('massUnit')?></strong></th>
    <th style="text-align: center;"><strong>x Preis in <?= setting('currencyUnit') ?></strong></th>
</tr>

<?php } ?>

<tr>
    <?php
        $price = $deliveryNote->getSupplier()->getHasFullPayout() ?
            $deliveryNote->getPrice()->getPrice() : $deliveryNote->getPrice()->getPricePayout();
        $sumAmount += $deliveryNote->getAmount();
        $sumPayout += $price * $deliveryNote->getAmount();
    ?>
    <td style="text-align: right;"><?= $deliveryNote->getNr() ?></td>
    <td style="text-align: center;"><?= date("d.m.Y", strtotime($deliveryNote->getDeliveryDate())) ?></td>
    <td style="text-align: right;"><?= $deliveryNote->getAmount() ?></td>
    <td style="text-align: right;">x <?= $price ?> = <?= Format::Currency($price * $deliveryNote->getAmount()) ?></td>
</tr>

<?php } ?>

<tr style="height:2px;"><td style="height:2px;" colspan="4"><hr></td></tr>
<tr>
    <td></td>
    <td style="text-align: right;">Summe:</td>
    <td style="text-align: right;"><?= $sumAmount ?></td>
    <td style="text-align: right;"><?= Format::Currency($sumPayout) ?></td>
</tr>
</table><br><br>

</td></tr></table>
