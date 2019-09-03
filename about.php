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

    // Check permission
    if(!isLoggedIn()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';
?>

<h1>Systeminformationen</h1>

<table>
    <tr>
        <td>Bio-Manager Version</td>
        <td style="text-align: right">1.3.5</td>
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

<?php
    include 'modules/footer.php';
?>
