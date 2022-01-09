<?php
/*
* editCommonConfig.php
* ------------------
* This form is used to edit the data for common settings.
*
* @Author: David Hein
*/

include 'modules/header_user.php';
include 'modules/PermissionCheck.php';

// Check permission
if (!isAdmin()) {
    header("Location: index.php");
    exit();
}

include 'modules/header.php';

include 'modules/formHelper.php';
?>

<h1>Allgemeine Einstellungen bearbeiten</h1>

<?php
if (isset($_GET['edit'])) {
    // --- Write new imprint data in config file ---
    $myfile = fopen("./config/CommonConfig.php", "w");
    // Create file content
    $txt = '<?php
    // Configuration for data which will be shown in invoice
    // Important: Use web interface to change the data. This file will be written from there.
    $common["organisation"] = "' . secPOST('organisation') . '";
?>';
    fwrite($myfile, $txt);
    fclose($myfile);

    echo '<div class="infobox">';
    echo 'Die Änderungen wurden erfolgreich gespeichert';
    echo '</div>';
    // Include after writing so the new content will be shown in form
    include_once 'config/CommonConfig.php';
} else {
    // Check if file exists to prevent warnings
    if (file_exists('config/CommonConfig.php')) {
        include_once 'config/CommonConfig.php';
    }
}
    $common = $common ?? null;
?>
<form action="?edit=1" method="post" class="requiredLegend">

<?php
    generateArrayField($common, "organisation", "text", "Organisation/Unternehmen", "Organisation", true);
?>
        
    <button>Änderungen speichern</button>
</form>
<?php
    include 'modules/footer.php';
?>