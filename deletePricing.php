<?php
/*
* deletePricing.php
* ------------------
* This form is used to delete a pricing.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/
    include 'templates/deleteForm.php';

    $form = new deleteForm();
    $form -> heading            = "Preis löschen";

    $form -> accessPermission   = "isMaintainer()";
    $form -> returnPage         = "product.php";

    $form -> linkPermission     = "true";
    $form -> linkElement        = '<a href="pricing.php">Alle Preise anzeigen</a>';
    $form -> linkAllElements    = '<a href="pricing.php">Alle Preise anzeigen</a>';

    $form -> table              = 'T_Pricing';

    $form -> overviewPage       = 'pricing.php';

    $form -> show();
?>