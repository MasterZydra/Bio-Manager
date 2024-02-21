<?php

/** @var string $year */

use Framework\Database\Database;
use Framework\Facades\Format;
use Framework\Facades\Http;
use Framework\Message\Message;
use Framework\Message\Type;

?>

<table cellpadding="5" cellspacing="0" style="width: 100%;">
<tr>
<td width="100%">

<h1 style="text-align: center;">Mengenverteilung <?= $year ?></h1><br>

<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">

<tr style="background-color: #4a8a16; padding:5px; color:white;">
<td style="padding:5px;"><b>Flurstück</b></td>
<td><b>Name</b></td>
<td><b>Menge in <?= setting('massUnit') ?></b></td>
</tr>

<?php

$dataSet = Database::prepared(
    'SELECT plots.nr, plots.name, SUM(volumeDistributions.amount) AS amount ' .
    'FROM deliveryNotes ' .
    'RIGHT JOIN volumeDistributions ON deliveryNotes.id = volumeDistributions.deliveryNoteId ' .
    'LEFT JOIN plots ON volumeDistributions.plotId = plots.id ' .
    'WHERE deliveryNotes.year = ? ' .
    'GROUP BY plots.nr',
    'i',
    $year
);

if ($dataSet === false) {
    Message::setMessage('An unkown error occured while creating the PDF', Type::Error);
    Http::redirect('/showVolumeDistribution');
}

$totalAmount = 0;

while ($row = $dataSet->fetch_assoc()) {
    $totalAmount += $row['amount'];
?>
<tr>
    <td style="text-align: left;"><?= $row['nr'] ?></td>
    <td style="text-align: left;"><?= $row['name'] ?></td>
    <td style="text-align: right;"><?= Format::Decimal($row['amount']) ?></td>
</tr>
<?php } ?>

</table>

</td></tr></table>

<hr>

<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">
<tr>
<td colspan="3"><b>Gesamtmenge in <?= setting('massUnit') ?>: </b></td>
<td style="text-align: right;"><b><?= Format::Decimal($totalAmount) ?></b></td>
</tr> 
</table>
