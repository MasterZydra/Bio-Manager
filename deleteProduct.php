<?php

include 'System/Autoloader.php';

/*
* deleteProdcut.php
* -----------------
* This form is used to delete a product.
*
* @Author: David Hein
*/

$form = new \System\Templates\DeleteForm();
$form -> heading            = "Produkt löschen";

$form -> accessPermission   = "isMaintainer";
$form -> returnPage         = "product.php";

$form -> linkPermission     = true;
$form -> linkElement        = '<a href="product.php">Alle Produkte anzeigen</a>';
$form -> linkAllElements    = '<a href="product.php">Alle Produkte anzeigen</a>';

$form -> table              = 'T_Product';

$form -> overviewPage       = 'product.php';

$form -> show();
