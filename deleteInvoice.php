<?php
/*
* deleteInvoice.php
* -----------------
* This form is used to delete an invoice.
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
    $form -> heading            = "Rechnung löschen";

    $form -> accessPermission   = "isMaintainer";
    $form -> returnPage         = "invoice.php";

    $form -> linkPermission     = true;
    $form -> linkElement        = '<a href="invoice.php">Alle Rechnungen anzeigen</a>';
    $form -> linkAllElements    = '<a href="invoice.php">Alle Rechnungen anzeigen</a>';

    $form -> table              = 'T_Invoice';

    $form -> overviewPage       = 'invoice.php';

    // Free delivery notes from invoice
    $form -> updateBeforeDelete  = array(
        array('T_DeliveryNote', 'invoiceId = NULL', 'invoiceId = ' . $_GET['id']));

    $form -> show();
?>