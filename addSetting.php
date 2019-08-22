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
    if(isset($_GET['add'])) {
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
?>
<form action="?add=1" method="post">
    <label>Name:<br>
        <input type="text" name="settingName" placeholder="Name eingeben" required autofocus>
    </label><br>
    <label>Beschreibung:<br>
        <input type="text" name="settingDesc" placeholder="Beschreibung eingeben" required>
    </label><br>
    <label>Wert:<br>
        <input type="text" name="settingValue" placeholder="Wert eingeben" required>
    </label><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>