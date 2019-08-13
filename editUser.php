<?php
    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';
    
    // Check permission
    if(!isAdmin()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';
?>

<h1>Benutzer bearbeiten</h1>

<p>
    <a href="user.php">Alle Benutzer anzeigen</a>    
</p>

<?php
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Benutzer übergeben. Zurück zu <a href="user.php">Alle Benutzer anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        
        if(isset($_GET['edit'])) {
            $conn -> freeRun(
                'UPDATE T_User '
                . 'SET name = \'' . $_POST['userName'] . '\' '
                . 'WHERE id = ' . $_POST['userId']);
           $conn -> freeRun(
                'UPDATE T_UserLogin '
                . 'SET login = \'' . $_POST['userLogin'] . '\', '
                . 'forcePwdChange = ' . $_POST['userForcePwdChange'] . ' '
                . 'WHERE userId = ' . $_POST['userId']);
            $conn -> freeRun(
                'UPDATE T_UserPermission '
                . 'SET isAdmin = ' . $_POST['userIsAdmin'] . ', '
                . 'isDeveloper = ' . $_POST['userIsDeveloper'] . ', '
                . 'isMaintainer = ' . $_POST['userIsMaintainer'] . ', '
                . 'isSupplier = ' . $_POST['userIsSupplier'] . ', '
                . 'isInspector = ' . $_POST['userIsInspector'] . ' '
                . 'WHERE userId = ' . $_POST['userId']);
            echo '<div class="infobox">';
            echo 'Die Änderungen wurden erfolgreich gespeichert';
            echo '</div>';
        }

        $conn->freeRun(
        'SELECT '
        . 'T_User.id, T_User.id AS userId, name, isAdmin, isDeveloper, isMaintainer, isSupplier, isInspector, forcePwdChange, login, supplierId '
        . 'FROM `T_User` '
        . 'LEFT JOIN `T_UserPermission` ON `T_UserPermission`.`userId` = `T_User`.`id` '
        . 'LEFT JOIN `T_UserLogin` ON `T_UserLogin`.`userId` = `T_User`.`id`'
        . 'WHERE T_User.id = ' . $_GET['id']);
        $row = $conn -> getFirstRow();
        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Der ausgewählte Benutzer wurde in der Datenbank nicht gefunden. Zurück zu <a href="user.php">Alle Benutzer anzeigen</a>';
            echo '</div>';
        }
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post">
    <label>Name:<br>
        <input type="text" name="userName" value="<?php echo $row['name']; ?>">
    </label><br>
    <label>Anmeldename:<br>
        <input type="text" name="userLogin" value="<?php echo $row['login']; ?>">
    </label><br>
    <label>
        <input type="hidden" name="userForcePwdChange" value="0">
        <input type="checkbox" name="userForcePwdChange" value="1" <?php if($row['forcePwdChange']) { echo 'checked'; } ?>>
        Passwortänderung erzwingen
    </label><br>
    <h2>Berechtigungen</h2>
    <label>
        <input type="hidden" name="userIsAdmin" value="0">
        <input type="checkbox" name="userIsAdmin" value="1" <?php if($row['isAdmin']) { echo 'checked'; } ?>>
        Administrator
    </label><br>
    <label>
        <input type="hidden" name="userIsDeveloper" value="0">
        <input type="checkbox" name="userIsDeveloper" value="1" <?php if($row['isDeveloper']) { echo 'checked'; } ?>>
        Entwickler
    </label><br>
    <label>
        <input type="hidden" name="userIsMaintainer" value="0">
        <input type="checkbox" name="userIsMaintainer" value="1" <?php if($row['isMaintainer']) { echo 'checked'; } ?>>
        Pfleger
    </label><br>
    <label>
        <input type="hidden" name="userIsSupplier" value="0">
        <input type="checkbox" name="userIsSupplier" value="1" <?php if($row['isSupplier']) { echo 'checked'; } ?>>
        Lieferant
    </label><br>
    <label>
        <input type="hidden" name="userIsInspector" value="0">
        <input type="checkbox" name="userIsInspector" value="1" <?php if($row['isInspector']) { echo 'checked'; } ?>>
        Prüfer
    </label><br>
    <button>Änderungen speichern</button>
</form>
<?php
    }
    include 'modules/footer.php';
?>