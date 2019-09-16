<?php
/*
* deleteProdcut.php
* -----------------
* This form is used to delete a product.
*
* @Author: David Hein
* 
* Changelog:
* ----------
* 16.09.2019:
*   - Change parameters for changed delete template.
*/
    include 'templates/deleteForm.php';

    $form = new deleteForm();
    $form -> heading            = "Produkt löschen";

    $form -> accessPermission   = "isMaintainer";
    $form -> returnPage         = "product.php";

    $form -> linkPermission     = true;
    $form -> linkElement        = '<a href="product.php">Alle Produkte anzeigen</a>';
    $form -> linkAllElements    = '<a href="product.php">Alle Produkte anzeigen</a>';

    $form -> table              = 'T_Product';

    $form -> overviewPage       = 'product.php';

    $form -> show();
?>