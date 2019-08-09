<?php
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);

    include 'modules/header_everyone.php';
    include 'modules/header.php';

    $invalidLogin = false;
    $noPermissionsSet = false;

    if(isset($_GET['login'])) {
        include 'modules/Mysql.php';
        include 'modules/helperFunctions.php';
        
        $login = $_POST['user_login'];
        $password = $_POST['user_password'];
        // Get user login data        
        $conn = new Mysql();
        $conn -> dbConnect();
        $result = $conn->selectWhere('T_UserLogin', 'login', '=', $login, 'char');
        $conn -> dbDisconnect();
        $conn = NULL;
        
        if ($result->num_rows == 0) {
            $invalidLogin = true;
        }
        else {
            $row = $result->fetch_assoc();
            // Check password
            if (!password_verify($password, $row['password'])) {
                $invalidLogin = true;
            }
            else {
                // Get user permissions
                $conn = new Mysql();
                $conn -> dbConnect();
                $result = $conn -> selectWhere('T_UserPermission', 'userId', '=', $row['userId'], 'int');
                $conn -> dbDisconnect();
                $conn = NULL;
                
                if ($result -> num_rows == 0) {
                    $noPermissionsSet = true;
                }
                else {
                    // Save session data
                    $row = $result->fetch_assoc();
                    $_SESSION['userId'] = $row['userId'];
                    $_SESSION['isAdmin'] = $row['isAdmin'];
                    $_SESSION['isDeveloper'] = $row['isDeveloper'];
                    echo '<div class="infobox">';
                    echo 'Anmeldung erfolgreich. Automatische Weiterleitung zur <a href="index.php">Startseite</a> erfolgt.';
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
        <label>Anmeldename:<br>
            <input type="text" size="40" maxlength="250" name="user_login">
        </label><br>
        <label>Passwort:<br>
            <input type="password" size="40"  maxlength="250" name="user_password">
        </label><br>       
        <button>Anmelden</button>
    </form>
<?php
    include 'modules/footer.php';
        
  /*
                    

//            echo 'Force: ' . $user['forcePwdChange'];
            
//            if ($user['forcePwdChange'] == 1) {
//                echo 'Change pwd';
//                die();
//            }
            
            
            exit();*/
?>

