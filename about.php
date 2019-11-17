<?php
/*
* about.php
* ---------
* This page contains information about this CRM system.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/
    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';
    include 'modules/header.php';
?>

<h1>Systeminformationen</h1>

<table>
    <tr>
        <td>Bio-Manager Version</td>
        <td style="text-align: right">1.3.6</td>
    </tr>
    <tr>
        <td>Entwickler</td>
        <td style="text-align: right">David Hein</td>
    </tr>
    <tr>
        <td>PHP Version</td>
        <td style="text-align: right"><?php echo phpversion(); ?></td>
    </tr>
</table>

<p>
    Haben Sie einen Fehler gefunden oder haben eine Verbesserungsidee oder Änderungswunsch?<br>
    Melden Sie sich unter <a href="mailto:david@techbasics.de">david@techbasics.de</a>.
</p>

<?php
    include 'modules/footer.php';
?>
