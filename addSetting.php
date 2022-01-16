<?php
/*
* addSetting.php
* ---------------
* This form is used to add a new setting.
*
* @Author: David Hein
*/
include 'System/Autoloader.php';

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (!(isAdmin() && isDeveloper())) {
    header("Location: setting.php");
    exit();
}

include 'Modules/header.php';

include 'Modules/selectBox_BioManager.php';
?>

<h1>Einstellung hinzufügen</h1>

<p>
    <a href="setting.php">Alle Einstellungen anzeigen</a>
</p>
<?php
    $alreadyExist = isset($_POST["settingName"]) && alreadyExistsSetting(secPOST("settingName"));
if (isset($_GET['add'])) {
    if ($alreadyExist) {
        echo '<div class="warning">';
        echo 'Die Einstellung <strong>' . secPOST("settingName") . '</strong> existiert bereits';
        echo '</div>';
    } else {
        $conn = new \System\Modules\Database\MySQL\MySql();
        $conn -> dbConnect();

        $NULL = [
            "type" => "null",
            "val" => "null"
        ];

        $setting_name = [
            "type" => "char",
            "val" => secPOST("settingName")
        ];

        $setting_desc = [
            "type" => "char",
            "val" => secPOST("settingDesc")
        ];

        $setting_value = [
            "type" => "char",
            "val" => secPOST("settingValue")
        ];

        // Add setting
        $data = array($NULL, $setting_name, $setting_desc, $setting_value);
        $conn -> insertInto('T_Setting', $data);
        $data = null;

        $conn -> dbDisconnect();

        echo '<div class="infobox">';
        echo 'Die Einstellung <strong>' . secPOST("settingName") . '</strong> wurde hinzugefügt';
        echo '</div>';
    }
}
?>
<form action="?add=1" method="post" class="requiredLegend">
    <label for="settingName" class="required">Name:</label><br>
    <input id="settingName" name="settingName" type="text" placeholder="Name eingeben" required autofocus
        <?php if ($alreadyExist) {
            echo ' value="' . secPOST("settingName") . '"';
        } ?>><br>
    
    <label for="settingDesc" class="required">Beschreibung:</label><br>
    <input id="settingDesc" name="settingDesc" type="text" placeholder="Beschreibung eingeben" required
        <?php if ($alreadyExist) {
            echo ' value="' . secPOST("settingDesc") . '"';
        } ?>><br>
    
    <label for="settingValue" class="required">Wert:</label><br>
    <input id="settingValue" name="settingValue" type="text" placeholder="Wert eingeben" required
        <?php if ($alreadyExist) {
            echo ' value="' . secPOST("settingValue") . '"';
        } ?>><br>
    
    <button>Hinzufügen</button>
</form>
<?php
    include 'Modules/footer.php';
?>