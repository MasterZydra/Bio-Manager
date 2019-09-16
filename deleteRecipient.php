<?php
/*
* deleteRecipient.php
* -------------------
* This form is used to delete a recipient.
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
    $form -> heading            = "Abnehmer löschen";

    $form -> accessPermission   = "isMaintainer";
    $form -> returnPage         = "recipient.php";

    $form -> linkPermission     = true;
    $form -> linkElement        = '<a href="recipient.php">Alle Abnehmer anzeigen</a>';
    $form -> linkAllElements    = '<a href="recipient.php">Alle Abnehmer anzeigen</a>';

    $form -> table              = 'T_Recipient';

    $form -> overviewPage       = 'recipient.php';

    $form -> show();
?>