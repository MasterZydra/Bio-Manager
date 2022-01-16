<?php
/*
* changeUserPwd.php
* ---------------
* This form is used to change a users password.
*
* @Author: David Hein
*/
include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (
    !isAdmin() ||
        // Check if id is numeric
        (isset($_GET['id']) && !is_numeric($_GET['id']))
) {
    header("Location: index.php");
    exit();
}

include 'Modules/header.php';
?>

<h1>Benutzerpasswort ändern</h1>

<p>
    <a href="user.php">Alle Benutzer anzeigen</a>    
</p>

<?php
if (!isset($_GET['id'])) {
    echo '<div class="warning">';
    echo 'Es wurde kein Benutzer übergeben. Zurück zu <a href="user.php">Alle Benutzer anzeigen</a>';
    echo '</div>';
} else {
    $conn = new \System\Modules\Database\MySQL\MySql();
    $conn -> dbConnect();

    if (isset($_GET['change'])) {
        $conn -> freeRun(
            'UPDATE T_UserLogin '
            . 'SET password = \'' . password_hash(secPOST('userPassword'), PASSWORD_DEFAULT) . '\', '
            . 'forcePwdChange = ' . secPOST('userForcePwdChange') . ' '
            . 'WHERE userId = ' . secGET('id')
        );
        echo '<div class="infobox">';
        echo 'Das Passwort wurden erfolgreich geändert';
        echo '</div>';
    }

    $conn -> select('T_UserLogin', 'userId, login, forcePwdChange', 'userId = ' . secGET('id'));
    $row = $conn -> getFirstRow();
    $conn -> dbDisconnect();
    $conn = null;

    // Check if id is valid
    if ($row == null) {
        echo '<div class="warning">';
        echo 'Der ausgewählte Benutzer wurde in der Datenbank nicht gefunden.';
        echo 'Zurück zu <a href="user.php">Alle Benutzer anzeigen</a>';
        echo '</div>';
    }
    ?>
<form action="?id=<?php echo $row['userId']; ?>&change=1" method="post">
    <label>Anmeldename:<br>
        <input type="text" value="<?php echo $row['login']; ?>" readonly>
    </label><br>
    
    <label for="userPassword" class="required">Neues Passwort:</label><br>
    <input id="userPassword" name="userPassword" type="password" required autofocus><br>
    
    <label>
        <input type="hidden" name="userForcePwdChange" value="0">
        <input type="checkbox" name="userForcePwdChange" value="1" <?php if ($row['forcePwdChange']) {
            echo 'checked';
                                                                   } ?>>
        Passwortänderung erzwingen
    </label><br>
    <button>Passwort ändern</button>
</form>
    <?php
}
    include 'Modules/footer.php';
?>