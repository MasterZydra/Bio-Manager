<?php
/*
* initDBConnection.php
* --------------------
* This form is used to edit the data for database connection.
*
* @Author: David Hein
*/
include 'modules/permissionCheck.php';

// Check if file exists to prevent warnings
if (file_exists('config/DatabaseConfig.php')) {
    include_once 'config/DatabaseConfig.php';
}

// Check permission
if (
    isLoggedIn() ||
        (file_exists('config/DatabaseConfig.php') && isset($database))
) {
    header("Location: index.php");
    exit();
}

include 'modules/header.php';

include 'modules/formHelper.php';
?>

<h1>Datenbankverbindung einrichten</h1>

<?php
if (isset($_GET['edit'])) {
    // --- Write new imprint data in config file ---
    $myfile = fopen("./config/DatabaseConfig.php", "w");
    // Create file content
    $txt = '<?php
    // Configuration for database connection
    // Important: Use web interface to change the data. This file will be written from there.
    $database["server_name"] = "' . secPOST('server_name') . '";
    $database["database_name"] = "' . secPOST('database_name') . '";
    $database["database_username"] = "' . secPOST('database_username') . '";
    $database["database_password"] = "' . secPOST('database_password') . '";
?>';
    fwrite($myfile, $txt);
    fclose($myfile);

    echo '<div class="infobox">';
    echo 'Die Änderungen wurden erfolgreich gespeichert';
    echo '</div>';
}
    $database ??= null;
?>
<form action="?edit=1" method="post" class="requiredLegend">
<?php
    generateArrayField($database, "server_name", "text", "Name des Servers", "Name des Servers", true);
    generateArrayField($database, "database_name", "text", "Name der Datenbank", "Name der Datenbank");
    generateArrayField($database, "database_username", "text", "Benutzername", "Benutzername");
    generateArrayField($database, "database_password", "password", "Passwort", "Passwort");
?>
    
    <button>Änderungen speichern</button>
</form>
<?php
    include 'modules/footer.php';
?>