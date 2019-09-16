<?php
/*
* deleteSetting.php
* --------------
* This form is used to delete a setting.
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
    $form -> heading            = "Einstellung löschen";

    $form -> accessPermission   = "isDeveloper";
    $form -> returnPage         = "setting.php";

    $form -> linkPermission     = true;
    $form -> linkElement        = '<a href="setting.php">Alle Einstellungen anzeigen</a>';
    $form -> linkAllElements    = '<a href="setting.php">Alle Einstellungen anzeigen</a>';

    $form -> table              = 'T_Setting';

    $form -> overviewPage       = 'setting.php';

    $form -> show();
?>