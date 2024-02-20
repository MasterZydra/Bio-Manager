<?php
/** @var \App\Models\Invoice $invoice */

use Framework\Facades\Format;

?>

<table cellpadding="0" cellspacing="0" style="width: 100%;">
<!-- Sender address -->
<tr>

<td width="60%">
<?= setting('invoiceSenderName') ?><br>
<?= setting('invoiceSenderStreet') ?><br>
<?= setting('invoiceSenderPostalCode') ?> <?= setting('invoiceSenderCity') ?><br>
<?= setting('invoiceSenderAddition') ?>
</td>

<td width="25%">
Rechnungsnummer:<br>
Rechnungsdatum:
</td>

<td width="15%" style="text-align: right;">
<?= $invoice->getNr() ?><br>
<?= date('d.m.Y', strtotime($invoice->getInvoiceDate())) ?>
</td>

</tr>
<!-- Invoice title -->
<tr>

<td style="font-size:1.3em; font-weight: bold;">
<br><br><?= setting('invoiceName') ?>
</td>

</tr>

<!-- Recipient address -->
<tr>

<td colspan="2">
<br><br>
<?php $recipient = $invoice->getRecipient(); ?>
<?= $recipient->getName() ?><br>
<?= $recipient->getStreet() ?><br>
<?= $recipient->getPostalCode() ?> <?= $recipient->getCity() ?><br>
</td>

</tr>
</table>
<br><br>

<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">

<tr style="background-color: #4a8a16; padding:5px; color:white;">
<td style="text-align: center;vertical-align: middle;"><b>Lieferschein-Nr</b></td>
<td style="text-align: center;vertical-align: middle;"><b>Lieferdatum</b></td>
<td style="text-align: center;vertical-align: middle;"><b>Produkt</b></td>
<td style="text-align: center;vertical-align: middle;"><b>Menge</b></td>
<td style="text-align: center;vertical-align: middle;"><b>Preis</b></td>
</tr>

<!-- List items -->
<?php /** @var \App\Models\DeliveryNote $deliveryNote */
foreach ($invoice->getDeliveryNotes() as $deliveryNote) { ?>

<tr>
<td style="text-align: center;"><?= $deliveryNote->getNr() ?></td>
<td style="text-align: center;"><?= date("d.m.Y", strtotime($deliveryNote->getDeliveryDate())) ?></td>
<td style="text-align: center;"><?= $deliveryNote->getProduct()->getName() ?></td>
<td style="text-align: right;"><?= $deliveryNote->getAmount() ?> <?= setting('massUnit') ?></td>
<td style="text-align: center;"><?= Format::Currency($deliveryNote->getPositionPrice()) ?></td>
</tr>

<?php } ?>

</table>

<hr>

<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">

<!--
if ($umsatzsteuer > 0) { $netto = $totalAmount / (1 + $umsatzsteuer); $umsatzsteuer_betrag = $totalAmount - $netto;
<tr>
<td colspan="3">Zwischensumme (Netto)</td>
<td style="text-align: center;">' . number_format($netto, 2, ',', '') . ' Euro</td>
</tr>
<tr>
<td colspan="3">Umsatzsteuer (' . intval($umsatzsteuer * 100) . '%)</td>
<td style="text-align: center;">' . number_format($umsatzsteuer_betrag, 2, ',', '.') . ' Euro</td>
</tr>';
}
-->

<tr>
<td colspan="3"><b>Gesamtbetrag: </b></td>
<td style="text-align: center;"><b><?= Format::Currency($invoice->getTotalPrice()) ?></b></td>
</tr> 

</table>

<!--
if (isset($comment)) {
    $html .= $comment;
    $html .= '<br><br><br>';
}
-->

<br><br><br>

<strong>Bankverbindung</strong><br>
<?= setting('invoiceBankName') ?><br>
IBAN: <?= Format::IBAN(setting('invoiceIBAN')) ?><br>
BIC: <?= setting('invoiceBIC') ?>
