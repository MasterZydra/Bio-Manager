<?php
/*
* deleteUser.php
* --------------
* This form is used to delete an user.
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
    $form -> heading            = "Benutzer löschen";

    $form -> accessPermission   = "isAdmin";
    $form -> returnPage         = "user.php";

    $form -> linkPermission     = true;
    $form -> linkElement        = '<a href="user.php">Alle Benutzer anzeigen</a>';
    $form -> linkAllElements    = '<a href="user.php">Alle Benutzer anzeigen</a>';

    $form -> table              = 'T_User';

    $form -> overviewPage       = 'user.php';

    // Delete data from the tables which contain additional user data
    $form -> deleteBeforeDelete  = array(
        array('T_UserLogin', 'userId', $_GET['id']),
        array('T_UserPermission', 'userId', $_GET['id']));

    $form -> show();
?>