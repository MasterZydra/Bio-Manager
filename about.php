<?php
/*
* about.php
* ---------
* This page contains information about this CRM system.
*
* @Author: David Hein
*/
include 'System/Autoloader.php';

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';
include 'Modules/header.php';
?>

<h1>Systeminformationen</h1>

<table>
    <tr>
        <td>Bio-Manager Version</td>
        <td class="right">1.3.10</td>
    </tr>
    <tr>
        <td>Entwickler</td>
        <td class="right">David Hein</td>
    </tr>
    <tr>
        <td>PHP Version</td>
        <td class="right"><?php echo phpversion(); ?></td>
    </tr>
</table>

<p>
    Haben Sie einen Fehler gefunden oder haben eine Verbesserungsidee oder Änderungswunsch?<br>
    Melden Sie sich unter <a href="mailto:david@techbasics.de">david@techbasics.de</a>.
</p>

<?php
    include 'Modules/footer.php';
?>
