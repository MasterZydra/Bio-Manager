<?php
/*
* login.php
* ---------------
* This form is used to login into the internal area.
* Basis for the login system: https://www.php-einfach.de/experte/php-codebeispiele/loginscript/
*
* @Author: David Hein
*/
include 'modules/header_everyone.php';
include 'modules/permissionCheck.php';
include 'modules/header.php';

$invalidLogin = false;
$noPermissionsSet = false;

if (isset($_GET['login'])) {
    $login = secPOST('user_login');
    $password = secPOST('user_password');
    // Get user login data
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn->select('T_UserLogin', '*', "login = '$login'");
    $conn -> dbDisconnect();
    $conn = null;

    if ($result->num_rows == 0) {
        $invalidLogin = true;
    } else {
        $row = $result->fetch_assoc();
        // Check password
        if (!password_verify($password, $row['password'])) {
            $invalidLogin = true;
        } else {
            $_SESSION['userId'] = $row['userId'];

            if ($row['forcePwdChange']) {
                echo '<div class="warning">';
                echo 'Sie müssen Ihr Passwort ändern.';
                echo 'Automatische Weiterleitung zu <a href="changePwd.php">Passwort ändern</a> erfolgt.';
                echo '</div>';
                echo '<script>window.location.replace("changePwd.php");</script>';
            } else {
                echo '<div class="infobox">';
                echo 'Anmeldung erfolgreich.';
                echo 'Automatische Weiterleitung zur <a href="index.php">Startseite</a> erfolgt.';
                echo '</div>';
                echo '<script>window.location.replace("index.php");</script>';
            }
        }
    }
}

    // No result for username or wrong password
if ($invalidLogin) {
    echo '<div class="warning">';
    echo 'Anmeldung nicht korrekt. Bitte prüfen Sie den Anmeldename und Passwort.';
    echo '</div>';
}
    // No result for username or wrong password
if ($noPermissionsSet) {
    echo '<div class="warning">';
    echo 'Es sind keine Berechtigungen vergeben. Bitte wenden Sie sich an den Administrator.';
    echo '</div>';
}

?>
    <form action="?login=1" method="post">
        <label for="user_login" class="required">Anmeldename:</label><br>
        <input id="user_login" name="user_login" type="text" size="40" maxlength="250" required autofocus><br>
        
        <label for="user_password" class="required">Passwort:</label><br>
        <input id="user_password" name="user_password" type="password" size="40"  maxlength="250" required><br>
        <button>Anmelden</button>
    </form>
<?php
    include 'modules/footer.php';
?>

