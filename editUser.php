<?php
/*
* editUser.php
* ---------------
* This form is used to edit a users name, login and permissions.
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

    include 'modules/selectBox_BioManager.php';
?>

<h1>Benutzer bearbeiten</h1>

<p>
    <a href="user.php">Alle Benutzer anzeigen</a>    
</p>

<?php
    $alreadyExist = false;
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Benutzer übergeben. Zurück zu <a href="user.php">Alle Benutzer anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        
        $alreadyExist = isset($_POST["userLogin"]) && alreadyExistsUser($_POST["userLogin"], $_GET['id']);
        if(isset($_GET['edit'])) {
            if($alreadyExist) {
                echo '<div class="warning">';
                echo 'Ein Benutzer mit dem Login <strong>' . $_POST["userLogin"] . '</strong> existiert bereits';
                echo '</div>';
            } else {
                $set = 'name = \'' . $_POST['userName'] .'\'';
                if(!isset($_POST["supplierId"]) || !$_POST["supplierId"]) {
                    $set .= ', supplierId = NULL';
                } else {
                    $set .= ', supplierId = ' . $_POST["supplierId"];
                }
                $conn -> update(
                    'T_User',
                    $set,
                    'id = ' . $_GET['id']);
                $conn -> update(
                    'T_UserLogin',
                    'login = \'' . $_POST['userLogin'] . '\', '
                    . 'forcePwdChange = ' . $_POST['userForcePwdChange'],
                    'userId = ' . $_GET['id']);
                $conn -> update(
                    'T_UserPermission',
                    'isAdmin = ' . $_POST['userIsAdmin'] . ', '
                    . 'isDeveloper = ' . $_POST['userIsDeveloper'] . ', '
                    . 'isMaintainer = ' . $_POST['userIsMaintainer'] . ', '
                    . 'isSupplier = ' . $_POST['userIsSupplier'] . ', '
                    . 'isInspector = ' . $_POST['userIsInspector'],
                    'userId = ' . $_GET['id']);
                echo '<div class="infobox">';
                echo 'Die Änderungen wurden erfolgreich gespeichert';
                echo '</div>';
            }
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
        <input type="text" name="userName" required autofocus value=
            <?php
                if($alreadyExist) {
                    echo '"' . $_POST["userName"] . '"';
                } else {
                    echo '"' . $row['name'] . '"';
                }
            ?>>
    </label><br>
    <label>Anmeldename:<br>
        <input type="text" name="userLogin" required value=
            <?php
                if($alreadyExist) {
                    echo '"' . $_POST["userLogin"] . '"';
                } else {
                    echo '"' . $row['login'] . '"';
                }
            ?>>
    </label><br>
    <label>
        <input type="hidden" name="userForcePwdChange" value="0">
        <input type="checkbox" name="userForcePwdChange" value="1"
           <?php
                if((!$alreadyExist && $row['forcePwdChange']) || ($alreadyExist && $_POST['userForcePwdChange'])) {
                    echo 'checked';
                }
           ?>>
        Passwortänderung erzwingen
    </label><br>
    <h2>Berechtigungen</h2>
    <label>
        <input type="hidden" name="userIsAdmin" value="0">
        <input type="checkbox" name="userIsAdmin" value="1"
            <?php
                if((!$alreadyExist && $row['isAdmin']) || ($alreadyExist && $_POST['userIsAdmin'])) {
                    echo 'checked';
                }
           ?>>
        Administrator
    </label><br>
    <label>
        <input type="hidden" name="userIsDeveloper" value="0">
        <input type="checkbox" name="userIsDeveloper" value="1"
            <?php
                if((!$alreadyExist && $row['isDeveloper']) || ($alreadyExist && $_POST['userIsDeveloper'])) {
                    echo 'checked';
                }
           ?>>
        Entwickler
    </label><br>
    <label>
        <input type="hidden" name="userIsMaintainer" value="0">
        <input type="checkbox" name="userIsMaintainer" value="1"
            <?php
                if((!$alreadyExist && $row['isMaintainer']) || ($alreadyExist && $_POST['userIsMaintainer'])) {
                    echo 'checked';
                }
           ?>>
        Pfleger
    </label><br>
    <label>
        <input type="hidden" name="userIsInspector" value="0">
        <input type="checkbox" name="userIsInspector" value="1"
            <?php
                if((!$alreadyExist && $row['isInspector']) || ($alreadyExist && $_POST['userIsInspector'])) {
                    echo 'checked';
                }
           ?>>
        Prüfer
    </label><br>
    <label>
        <input type="hidden" name="userIsSupplier" value="0">
        <input type="checkbox" name="userIsSupplier" value="1"
            <?php
                if((!$alreadyExist && $row['isSupplier']) || ($alreadyExist && $_POST['userIsSupplier'])) {
                    echo 'checked';
                }
           ?>>
        Lieferant
    </label><br>
    <label>Lieferant:<br>
        <?php
            if($alreadyExist && $_POST['supplierId']) {
                echo supplierSelectBox(false, $_POST['supplierId'], false);
            } else {
                echo supplierSelectBox(false, $row['supplierId'], false);
            }
         ?>
    </label><br>
    <button>Änderungen speichern</button>
</form>
<?php
    }
    include 'modules/footer.php';
?>