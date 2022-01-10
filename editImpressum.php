<?php
/*
* editImpressum.php
* ---------------
* This form is used to edit the contents in the impressum.
*
* @Author: David Hein
*/

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (!isAdmin()) {
    header("Location: index.php");
    exit();
}

include 'Modules/header.php';

include 'Modules/formHelper.php';
?>

<h1>Impressum bearbeiten</h1>

<?php
if (isset($_GET['edit'])) {
    // --- Write new imprint data in config file ---
    $myfile = fopen("./config/ImpressumConfig.php", "w");
    // Create file content
    $txt = '<?php
    // Configuration for data which will be shown in impressum
    // Important: Use web interface to change the data. This file will be written from there.
    $impressum["provider_name"] = "' . secPOST('provider_name') . '";
    $impressum["provider_street"] = "' . secPOST('provider_street') . '";
    $impressum["provider_postalCode"] = "' . secPOST('provider_postalCode') . '";
    $impressum["provider_city"] = "' . secPOST('provider_city') . '";
    $impressum["provider_email"] = "' . secPOST('provider_email') . '";

    $impressum["responsible_name"] = "' . secPOST('responsible_name') . '";
    $impressum["responsible_street"] = "' . secPOST('responsible_street') . '";
    $impressum["responsible_postalCode"] = "' . secPOST('responsible_postalCode') . '";
    $impressum["responsible_city"] = "' . secPOST('responsible_city') . '";
    $impressum["responsible_email"] = "' . secPOST('responsible_email') . '";
?>';
    fwrite($myfile, $txt);
    fclose($myfile);

    echo '<div class="infobox">';
    echo 'Die Änderungen wurden erfolgreich gespeichert';
    echo '</div>';
    // Include after writing so the new content will be shown in form
    include 'config/ImpressumConfig.php';
} else {
    // Check if file exists to prevent warnings
    if (file_exists('config/ImpressumConfig.php')) {
        include 'config/ImpressumConfig.php';
    }
}
    $impressum = $impressum ?? null;
?>
<form action="?edit=1" method="post" class="requiredLegend">
    <h2>Anbieter (Privatperson oder Unternehmen)</h2>
<?php
    generateArrayField($impressum, "provider_name", "text", "Name", "Vorname Nachname", true);
    generateArrayField($impressum, "provider_street", "text", "Straße", "Straße Hausnummer");
    generateArrayField($impressum, "provider_postalCode", "number", "Postleitzahl", "Postleitzahl");
    generateArrayField($impressum, "provider_city", "text", "Stadt", "Stadt");
    generateArrayField($impressum, "provider_email", "email", "Email", "Email");
?>
    
    <h2>Datenschutzbeauftragter</h2>
<?php
    generateArrayField($impressum, "responsible_name", "text", "Name", "Vorname Nachname");
    generateArrayField($impressum, "responsible_street", "text", "Straße", "Straße Hausnummer");
    generateArrayField($impressum, "responsible_postalCode", "number", "Postleitzahl", "Postleitzahl");
    generateArrayField($impressum, "responsible_city", "text", "Stadt", "Stadt");
    generateArrayField($impressum, "responsible_email", "email", "Email", "Email");
?>
    
    <button>Änderungen speichern</button>
</form>
<?php
    include 'Modules/footer.php';
?>