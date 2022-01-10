<?php
/*
* changePwd.php
* ---------------
* This form is used from the user to change his password.
*
* @Author: David Hein
*/

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';
include 'Modules/header.php';
?>
<h1>Passwort ändern</h1>
<?php
if (isset($_GET['change'])) {
    $curPassword = secPOST('curPassword');
    $newPassword  = secPOST('newPassword');
    $newPassword2 = secPOST('newPassword2');

    // Check old password
    $conn = new Mysql();
    $conn -> dbConnect();
    $conn -> select('T_UserLogin', 'password', 'userId = ' . $_SESSION['userId']);
    $row = $conn -> getFirstRow();
    $conn -> dbDisconnect();
    $conn = null;
    $invalidPwd = false;
    if ($row == null) {
        $invalidPwd = true;
    } else {
        if (!password_verify($curPassword, $row['password'])) {
            $invalidPwd = true;
        }
    }

    if ($invalidPwd) {
        echo '<div class="warning">';
        echo 'Das Passwort ist falsch. Bitte überprüfen Sie ihre Eingabe.';
        echo '</div>';
    } elseif (strcmp($newPassword, $newPassword2) !== 0) {
        echo '<div class="warning">';
        echo 'Das neuen Passwörter stimmen nicht überein';
        echo '</div>';
    } elseif (strcmp($curPassword, $newPassword) == 0) {
        echo '<div class="warning">';
        echo 'Das alte und neue Passwort sind identisch';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        $conn -> freeRun(
            'UPDATE T_UserLogin '
            . 'SET forcePwdChange=0, '
            . 'password="' . password_hash($newPassword, PASSWORD_DEFAULT) . '" '
            . 'WHERE userId = ' . $_SESSION['userId']
        );
        $conn -> dbDisconnect();
        $conn = null;

        echo '<div class="infobox">';
        echo 'Das Passwort wurde geändert. Sie werden jetzt abgemeldet. <a href="logout.php">Abmelden</a> erfolgt.';
        echo '</div>';
        echo '<script>window.location.replace("logout.php");</script>';
    }
}
?>
    <form action="?change=1" method="post">
        <label for="curPassword" class="required">Aktuelles Passwort:</label><br>
        <input id="curPassword" name="curPassword" type="password" size="40" maxlength="250" required autofocus><br><br>

        <label for="newPassword" class="required">Neues Passwort:</label><br>
        <input id="newPassword" name="newPassword" type="password" size="40" maxlength="250" required><br>

        <label for="newPassword2" class="required">Neues Passwort wiederholen:</label><br>
        <input id="newPassword2" name="newPassword2" type="password" size="40" maxlength="250" required><br>

        <button>Passwort ändern</button>
    </form>
    <?php
    include 'Modules/footer.php';
    ?>