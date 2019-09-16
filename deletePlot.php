<?php
/*
* deletePlot.php
* --------------
* This form is used to delete a plot.
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
    $form -> heading            = "Flurstück löschen";

    $form -> accessPermission   = "isMaintainer";
    $form -> returnPage         = "plot.php";

    $form -> linkPermission     = true;
    $form -> linkElement        = '<a href="plot.php">Alle Flurstücke anzeigen</a>';
    $form -> linkAllElements    = '<a href="plot.php">Alle Flurstücke anzeigen</a>';

    $form -> table              = 'T_Plot';

    $form -> overviewPage       = 'plot.php';

    $form -> show();
?>