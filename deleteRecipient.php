<?php

/*
* deleteRecipient.php
* -------------------
* This form is used to delete a recipient.
*
* @Author: David Hein
*/
    include 'templates/DeleteForm.php';

    $form = new DeleteForm();
    $form -> heading            = "Abnehmer löschen";

    $form -> accessPermission   = "isMaintainer";
    $form -> returnPage         = "recipient.php";

    $form -> linkPermission     = true;
    $form -> linkElement        = '<a href="recipient.php">Alle Abnehmer anzeigen</a>';
    $form -> linkAllElements    = '<a href="recipient.php">Alle Abnehmer anzeigen</a>';

    $form -> table              = 'T_Recipient';

    $form -> overviewPage       = 'recipient.php';

    $form -> show();
