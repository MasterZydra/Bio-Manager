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
*/
    include 'templates/deleteForm.php';

    $form = new deleteForm();
    $form -> heading            = "Benutzer löschen";

    $form -> accessPermission   = "isAdmin()";
    $form -> returnPage         = "user.php";

    $form -> linkPermission     = "true";
    $form -> linkElement        = '<a href="user.php">Alle Benutzer anzeigen</a>';
    $form -> linkAllElements    = '<a href="user.php">Alle Benutzer anzeigen</a>';

    $form -> table              = 'T_User';

    $form -> overviewPage       = 'user.php';

    // Delete data from the tables which contain additional user data
    $form -> queryBeforeDelete  = "\$conn -> delete('T_UserLogin', 'userId=' . \$_GET['id']);" .
                                  "\$conn -> delete('T_UserPermission', 'userId=' . \$_GET['id']);";

    $form -> show();
?>