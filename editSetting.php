<?php
/*
* editSetting.php
* ---------------
* This form is used to edit a setting.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isAdmin()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';
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

        $conn -> select('T_Setting', '*', 'id = ' . $_GET['id']);
        $row = $conn -> getFirstRow();
        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Die ausgewählte Einstellung wurde in der Datenbank nicht gefunden. Zurück zu <a href="setting.php">Alle Einstellungen anzeigen</a>';
            echo '</div>';
        }
    }
?>

<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post">
    <label>Einstellung:<br>
        <input type="text" value="<?php echo $row['name']; ?>" readonly>
    </label><br>
    <label>Beschreibung:<br>
        <input type="text" name="settingDesc" value="<?php echo $row['description']; ?>" required autofocus>
    </label><br>
    <label>Wert:<br>
        <input type="text" name="settingValue" value="<?php echo $row['value']; ?>" required>
    </label><br>
    <button>Änderungen speichern</button>
</form>

<?php
    include 'modules/footer.php';
?>