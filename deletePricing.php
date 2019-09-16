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
* 16.09.2019:
*   - Change parameters for changed delete template.
*/
    include 'templates/deleteForm.php';

    $form = new deleteForm();
    $form -> heading            = "Preis löschen";

    $form -> accessPermission   = "isMaintainer";
    $form -> returnPage         = "product.php";

    $form -> linkPermission     = true;
    $form -> linkElement        = '<a href="pricing.php">Alle Preise anzeigen</a>';
    $form -> linkAllElements    = '<a href="pricing.php">Alle Preise anzeigen</a>';

    $form -> table              = 'T_Pricing';

    $form -> overviewPage       = 'pricing.php';

    $form -> show();
?>