<?php
/*
* addSetting.php
* ---------------
* This form is used to add a new setting.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';
    
    // Check permission
    if(!(isAdmin() && isDeveloper())) {
        header("Location: setting.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/selectBox_BioManager.php';
?>

<h1>Einstellung hinzufügen</h1>

<p>
    <a href="setting.php">Alle Einstellungen anzeigen</a>
</p>
<?php
    $alreadyExist = isset($_POST["settingName"]) && alreadyExistsSetting($_POST["settingName"]);
    if(isset($_GET['add'])) {
        if($alreadyExist) {
            echo '<div class="warning">';
            echo 'Die Einstellung <strong>' . $_POST["settingName"] . '</strong> existiert bereits';
            echo '</div>';
        } else {
            $conn = new Mysql();
            $conn -> dbConnect();

            $NULL = [
                "type" => "null",
                "val" => "null"
            ];

            $setting_name = [
                "type" => "char",
                "val" => $_POST["settingName"]
            ];

            $setting_desc = [
                "type" => "char",
                "val" => $_POST["settingDesc"]
            ];

            $setting_value = [
                "type" => "char",
                "val" => $_POST["settingValue"]
            ];

            // Add setting
            $data = array($NULL, $setting_name, $setting_desc, $setting_value);
            $conn -> insertInto('T_Setting', $data);
            $data = NULL;

            $conn -> dbDisconnect();

            echo '<div class="infobox">';
            echo 'Die Einstellung <strong>' . $_POST["settingName"] . '</strong> wurde hinzugefügt';
            echo '</div>';
        }
    }
?>
<form action="?add=1" method="post">
    <label for="settingName" class="required">Name:</label><br>
    <input id="settingName" name="settingName" type="text" placeholder="Name eingeben" required autofocus
        <?php if($alreadyExist) { echo ' value="' . $_POST["settingName"] . '"'; } ?>><br>
    
    <label for="settingDesc" class="required">Beschreibung:</label><br>
    <input id="settingDesc" name="settingDesc" type="text" placeholder="Beschreibung eingeben" required
        <?php if($alreadyExist) { echo ' value="' . $_POST["settingDesc"] . '"'; } ?>><br>
    
    <label for="settingValue" class="required">Wert:</label><br>
    <input id="settingValue" name="settingValue" type="text" placeholder="Wert eingeben" required
        <?php if($alreadyExist) { echo ' value="' . $_POST["settingValue"] . '"'; } ?>><br>
    
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>