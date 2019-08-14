<?php
/*
* changeUserPwd.php
* ---------------
* This form is used to change a users password.
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

<h1>Benutzerpasswort ändern</h1>

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
        
        if(isset($_GET['change'])) {
           $conn -> freeRun(
                'UPDATE T_UserLogin '
                . 'SET password = \'' . password_hash($_POST['userPassword'], PASSWORD_DEFAULT) . '\', '
                . 'forcePwdChange = ' . $_POST['userForcePwdChange'] . ' '
                . 'WHERE userId = ' . $_GET['id']);
            echo '<div class="infobox">';
            echo 'Das Passwort wurden erfolgreich geändert';
            echo '</div>';
        }

        $conn -> select('T_UserLogin', 'userId, login, forcePwdChange', 'userId = ' . $_GET['id']);
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
<form action="?id=<?php echo $row['userId']; ?>&change=1" method="post">
    <label>Anmeldename:<br>
        <input type="text" value="<?php echo $row['login']; ?>" readonly>
    </label><br>
    <label>Neues Passwort:<br>
        <input type="password" name="userPassword" autofocus>
    </label><br>
    <label>
        <input type="hidden" name="userForcePwdChange" value="0">
        <input type="checkbox" name="userForcePwdChange" value="1" <?php if($row['forcePwdChange']) { echo 'checked'; } ?>>
        Passwortänderung erzwingen
    </label><br>
    <button>Passwort ändern</button>
</form>
<?php
    }
    include 'modules/footer.php';
?>