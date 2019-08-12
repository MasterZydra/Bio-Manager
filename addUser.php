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

<h1>Benutzer hinzufügen</h1>

<p>
    <a href="user.php">Alle Benutzer anzeigen</a>    
</p>
<?php
    if(isset($_GET['add'])) {
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
        
        $user_vendorId = [
            "type" => "int",
            "val" => "0"
        ];
        
        $data = array($NULL, $user_name, $user_vendorId);
        $conn -> insertInto('T_User', $data);
        
        //$conn -> selectColumsWhere();
        
        
        //password_hash($newPassword, PASSWORD_DEFAULT)
        
        
        
        
        $conn -> dbDisconnect();
        
        echo '<div class="infobox">';
        echo 'Der Benutzer <strong>' . $_POST["userName"] . '</strong> wurde hinzugefügt';
        echo '</div>';
    }
?>
<form action="?add=1" method="post">
    <label>Name:<br>
        <input type="text" name="userName" placeholder="Benutzername eingeben" required>
    </label><br>
    <label>Anmeldename:<br>
        <input type="text" name="userLogin" placeholder="Anmeldename eingeben" required>
    </label><br>
    <label>Passwort:<br>
        <input type="password" name="userPassword" placeholder="Passwort eingeben" required>
    </label><br>
    <label>
        <input type="hidden" name="userForcePwdChange" value="0">
        <input type="checkbox" name="userForcePwdChange" value="1">
        Passwortänderung erzwingen
    </label><br>
    <h2>Berechtigungen</h2>
    <label>
        <input type="hidden" name="userIsAdmin" value="0">
        <input type="checkbox" name="userIsAdmin" value="1">
        Administrator
    </label><br>
    <label>
        <input type="hidden" name="userIsDeveloper" value="0">
        <input type="checkbox" name="userIsDeveloper" value="1">
        Entwickler
    </label><br>
    <label>
        <input type="hidden" name="userIsMaintainer" value="0">
        <input type="checkbox" name="userIsMaintainer" value="1">
        Pfleger
    </label><br>
    <label>
        <input type="hidden" name="userIsVendor" value="0">
        <input type="checkbox" name="userIsVendor" value="1">
        Lieferant
    </label><br>
    <label>
        <input type="hidden" name="userIsInspector" value="0">
        <input type="checkbox" name="userIsInspector" value="1">
        Prüfer
    </label><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>