<?php

include 'System/Autoloader.php';

/*
* deleteSetting.php
* --------------
* This form is used to delete a setting.
*
* @Author: David Hein
*/

$form = new \System\Templates\DeleteForm();
$form -> heading            = "Einstellung löschen";

$form -> accessPermission   = "isDeveloper";
$form -> returnPage         = "setting.php";

$form -> linkPermission     = true;
$form -> linkElement        = '<a href="setting.php">Alle Einstellungen anzeigen</a>';
$form -> linkAllElements    = '<a href="setting.php">Alle Einstellungen anzeigen</a>';

$form -> table              = 'T_Setting';

$form -> overviewPage       = 'setting.php';

$form -> show();
