<?php
/*
* editSetting.php
* ---------------
* This form is used to edit a setting.
*
* @Author: David Hein
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isAdmin()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';

    include_once 'modules/Mysql_preparedStatement_BioManager.php';
?>
<h1>Einstellung bearbeiten</h1>

<p>
    <a href="setting.php">Alle Einstellungen anzeigen</a>    
</p>

<?php
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Einstellung übergeben. Zurück zu <a href="setting.php">Alle Einstellungen anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        if(isset($_GET['edit'])) {
            $conn -> update(
                'T_Setting',
                'description = \'' . $_POST['settingDesc'] . '\', '
                . 'value = \'' . $_POST['settingValue'] . '\'',
                'id = ' . $_GET['id']);
            echo '<div class="infobox">';
            echo 'Die Änderungen wurden erfolgreich gespeichert';
            echo '</div>';
        }

        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Select data
        $prepStmt = new mysql_preparedStatement_BioManager();
        $row = $prepStmt -> selectWhereId("T_Setting", $_GET['id']);
        $prepStmt -> destroy();
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Die ausgewählte Einstellung wurde in der Datenbank nicht gefunden. Zurück zu <a href="setting.php">Alle Einstellungen anzeigen</a>';
            echo '</div>';
        } else {
?>

<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post" class="requiredLegend">
    <label>Einstellung:<br>
        <input type="text" value="<?php echo $row['name']; ?>" readonly>
    </label><br>
    
    <label for="settingDesc" class="required">Beschreibung:</label><br>
    <input id="settingDesc" name="settingDesc" type="text" value="<?php echo $row['description']; ?>" required autofocus><br>
    
    <label for="settingValue" class="required">Wert:</label><br>
    <input id="settingValue" name="settingValue" type="text" value="<?php echo $row['value']; ?>" required><br>
    
    <button>Änderungen speichern</button>
</form>

<?php
        }
    }
    include 'modules/footer.php';
?>