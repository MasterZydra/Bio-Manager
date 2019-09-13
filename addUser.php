<?php
/*
* addUser.php
* ---------------
* This form is used to add a new user.
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

<h1>Benutzer hinzufügen</h1>

<p>
    <a href="user.php">Alle Benutzer anzeigen</a>
</p>
<?php
    $alreadyExist = isset($_POST["userLogin"]) && alreadyExistsUser($_POST["userLogin"]);
    if(isset($_GET['add'])) {
        if($alreadyExist) {
            echo '<div class="warning">';
            echo 'Ein Benutzer mit dem Login <strong>' . $_POST["userLogin"] . '</strong> existiert bereits';
            echo '</div>';
        } else {
            $conn = new Mysql();
            $conn -> dbConnect();

            $NULL = [
                "type" => "null",
                "val" => "null"
            ];

            $user_name = [
                "type" => "char",
                "val" => $_POST["userName"]
            ];

            // SupplierId
            if(!isset($_POST["supplierId"]) || !$_POST["supplierId"]) {
                $user_supplierId = [
                    "type" => "null",
                    "val" => "null"
                ];
            } else {
                $user_supplierId = [
                    "type" => "int",
                    "val" => $_POST["supplierId"]
                ];
            }

            // Add user
            $data = array($NULL, $user_name, $user_supplierId);
            $conn -> insertInto('T_User', $data);
            $data = NULL;
            // Get user id
            $conn -> select('T_User', 'id', 'name = \'' . $_POST["userName"] . '\' ORDER BY id DESC');
            $user = $conn -> getFirstRow();
            if($user == NULL) {
                // Error do not continue
            }

            $user_id = [
                "type" => "int",
                "val" => $user['id']
            ];

            $user_login = [
                "type" => "char",
                "val" => $_POST['userLogin']
            ];

            $user_password = [
                "type" => "char",
                "val" => password_hash($_POST['userPassword'], PASSWORD_DEFAULT)
            ];

            $user_forcePwdChange = [
                "type" => "int",
                "val" => strval($_POST['userForcePwdChange'])
            ];

            // Add user login
            $data = array($NULL, $user_id, $user_login, $user_password, $user_forcePwdChange);
            $conn -> insertInto('T_UserLogin', $data);
            $data = NULL;

            $user_isAmin = [
                "type" => "int",
                "val" => strval($_POST['userIsAdmin'])
            ];

            $user_isDeveloper = [
                "type" => "int",
                "val" => strval($_POST['userIsDeveloper'])
            ];

            $user_isMaintainer = [
                "type" => "int",
                "val" => strval($_POST['userIsMaintainer'])
            ];

            $user_isSupplier = [
                "type" => "int",
                "val" => strval($_POST['userIsSupplier'])
            ];

            $user_isInspector = [
                "type" => "int",
                "val" => strval($_POST['userIsInspector'])
            ];

            $data = array($NULL, $user_id, $user_isAmin, $user_isDeveloper, $user_isMaintainer, $user_isSupplier, $user_isInspector);
            $conn -> insertInto('T_UserPermission', $data);
            $data = NULL;


            $conn -> dbDisconnect();

            echo '<div class="infobox">';
            echo 'Der Benutzer <strong>' . $_POST["userName"] . '</strong> wurde hinzugefügt';
            echo '</div>';
        }
    }
?>
<form action="?add=1" method="post">
    <label for="userName" class="required">Name:</label><br>
    <input id="userName" name="userName" type="text" placeholder="Benutzername eingeben" required autofocus
        <?php if($alreadyExist) { echo ' value="' . $_POST["userName"] . '"'; } ?>><br>
    
    <label for="userLogin" class="required">Anmeldename:</label><br>
    <input id="userLogin" name="userLogin" type="text" placeholder="Anmeldename eingeben" required
        <?php if($alreadyExist) { echo ' value="' . $_POST["userLogin"] . '"'; } ?>><br>
    
    <label for="userPassword" class="required">Passwort:</label><br>
    <input id="userPassword" name="userPassword" type="password" placeholder="Passwort eingeben" required
        <?php if($alreadyExist) { echo ' value="' . $_POST["userPassword"] . '"'; } ?>><br>
    
    <label>
        <input type="hidden" name="userForcePwdChange" value="0">
        <input type="checkbox" name="userForcePwdChange" value="1"
            <?php if($alreadyExist && $_POST['userForcePwdChange']) { echo ' checked'; } ?>>
        Passwortänderung erzwingen
    </label><br>
    
    <h2>Berechtigungen</h2>
    <label>
        <input type="hidden" name="userIsAdmin" value="0">
        <input type="checkbox" name="userIsAdmin" value="1"
            <?php if($alreadyExist && $_POST['userIsAdmin']) { echo ' checked'; } ?>>
        Administrator
    </label><br>
    <label>
        <input type="hidden" name="userIsDeveloper" value="0">
        <input type="checkbox" name="userIsDeveloper" value="1"
            <?php if($alreadyExist && $_POST['userIsDeveloper']) { echo ' checked'; } ?>>
        Entwickler
    </label><br>
    <label>
        <input type="hidden" name="userIsMaintainer" value="0">
        <input type="checkbox" name="userIsMaintainer" value="1"
            <?php if($alreadyExist && $_POST['userIsMaintainer']) { echo ' checked'; } ?>>
        Pfleger
    </label><br>
    <label>
        <input type="hidden" name="userIsInspector" value="0">
        <input type="checkbox" name="userIsInspector" value="1"
            <?php if($alreadyExist && $_POST['userIsInspector']) { echo ' checked'; } ?>>
        Prüfer
    </label><br>
    <label>
        <input type="hidden" name="userIsSupplier" value="0">
        <input type="checkbox" name="userIsSupplier" value="1"
            <?php if($alreadyExist && $_POST['userIsSupplier']) { echo ' checked'; } ?>>
        Lieferant
    </label><br>
    <label>Lieferant:<br>
        <?php
            if($alreadyExist) {
                echo supplierSelectBox(false, $_POST["supplierId"], false);
            } else {
                echo supplierSelectBox(false, NULL, false);
            }
        ?>
    </label><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>