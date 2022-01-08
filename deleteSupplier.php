<?php

/*
* deleteSupplier.php
* ------------------
* This form is used to delete a supplier.
*
* @Author: David Hein
*/
    include 'templates/deleteForm.php';

    $form = new deleteForm();
    $form -> heading            = "Lieferant löschen";

    $form -> accessPermission   = "isMaintainer";
    $form -> returnPage         = "supplier.php";

    $form -> linkPermission     = true;
    $form -> linkElement        = '<a href="supplier.php">Alle Lieferanten anzeigen</a>';
    $form -> linkAllElements    = '<a href="supplier.php">Alle Lieferanten anzeigen</a>';

    $form -> table              = 'T_Supplier';

    $form -> overviewPage       = 'supplier.php';

    $form -> show();
