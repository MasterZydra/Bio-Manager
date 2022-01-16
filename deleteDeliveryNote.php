<?php

include 'System/Autoloader.php';

/*
* deleteDeliveryNote.php
* ----------------------
* This form is used to delete a delivery note.
*
* @Author: David Hein
*/

$form = new \System\Templates\DeleteForm();
$form -> heading            = "Lieferschein löschen";

$form -> accessPermission   = "isMaintainer";
$form -> returnPage         = "deliveryNote.php";

$form -> linkPermission     = true;
$form -> linkElement        = '<a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>';
$form -> linkAllElements    = '<a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>';

$form -> table              = 'T_DeliveryNote';

$form -> overviewPage       = 'deliveryNote.php';

$form -> show();
