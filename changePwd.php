<?php
/*
* changePwd.php
* ---------------
* This form is used from the user to change his password.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';
    include 'modules/header.php';
?>
<h1>Passwort ändern</h1>
<?php
    if(isset($_GET['change'])) {
        $curPassword = $_POST['curPassword'];
        $newPassword  = $_POST['newPassword'];
        $newPassword2 = $_POST['newPassword2'];
        
        // Check old password
        $conn = new Mysql();
        $conn -> dbConnect();
        $conn -> select('T_UserLogin', 'password', 'userId = ' . $_SESSION['userId']);
        $row = $conn -> getFirstRow();
        $conn -> dbDisconnect();
        $conn = NULL;
        $invalidPwd = false;
        if($row == NULL) {
            $invalidPwd = true;
        }
        else {
            if (!password_verify($curPassword, $row['password'])) {
                $invalidPwd = true;
            }
        }
        
        if($invalidPwd) {
            echo '<div class="warning">';
            echo 'Das Passwort ist falsch. Bitte überprüfen Sie ihre Eingabe.';
            echo '</div>';
        }
        elseif(strcmp($newPassword, $newPassword2) !== 0) {
            echo '<div class="warning">';
            echo 'Das neuen Passwörter stimmen nicht überein';
            echo '</div>';
        }
        elseif(strcmp($curPassword, $newPassword) == 0) {
            echo '<div class="warning">';
            echo 'Das alte und neue Passwort sind identisch';
            echo '</div>';
        }
        else {
            $conn = new Mysql();
            $conn -> dbConnect();
            $conn -> freeRun(
                'UPDATE T_UserLogin '
                . 'SET forcePwdChange=0, '
                . 'password="' . password_hash($newPassword, PASSWORD_DEFAULT) . '" '
                . 'WHERE userId = ' . $_SESSION['userId']);
            $conn -> dbDisconnect();
            $conn = NULL;

            echo '<div class="infobox">';
            echo 'Das Passwort wurde geändert. Sie werden jetzt abgemeldet. <a href="logout.php">Abmelden</a> erfolgt.';
            echo '</div>';
            echo '<script>window.location.replace("logout.php");</script>';
        }
    }
?>
    <form action="?change=1" method="post">
        <label>Aktuelles Passwort:<br>
            <input type="password" size="40" maxlength="250" name="curPassword" required autofocus>
        </label><br><br>

        <label>Neues Passwort:<br>
            <input type="password" size="40" maxlength="250" name="newPassword" required>
        </label><br>

        <label>Neues Passwort wiederholen:<br>
            <input type="password" size="40" maxlength="250" name="newPassword2" required>
        </label><br>

        <button>Passwort ändern</button>
    </form>
    <?php
    include 'modules/footer.php';
?>