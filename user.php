<?php
/*
* user.php
* ----------------
* This page shows all users in a table. A filter can
* be used to find the wanted rows. A user needs
* administrator permissions to see and edit the users.
* Users can be added, deleted and edited.
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

    include 'modules/dataTable_BioManager.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>

<h1>Benutzer</h1>
<p>
    <a href="addUser.php">Benutzer hinzufügen</a>    
</p>

<?php
    if(isset($_GET['action']) && isset($_GET['id'])) {
        // Action - Delete user
        if($_GET['action'] == 'delete') {
            $conn = new Mysql();
            $conn -> dbConnect();
            $conn -> select('T_User', 'id', 'id = ' . $_GET['id']);
            $row = $conn -> getFirstRow();
            
            // Check if id is valid 
            if ($row == NULL) {
                echo '<div class="warning">';
                echo 'Der ausgewählte Benutzer wurde in der Datenbank nicht gefunden';
                echo '</div>';
            } else {
                // Delete user
                $conn -> freeRun('DELETE FROM T_User WHERE id=' . $row['id']);
                $conn -> freeRun('DELETE FROM T_UserLogin WHERE userId=' . $row['id']);
                $conn -> freeRun('DELETE FROM T_UserPermission WHERE userId=' . $row['id']);
                
                echo '<div class="infobox">';
                echo 'Der Benutzer wurde gelöscht.';
                echo '</div>';
            }
            $conn -> dbDisconnect();
            $conn = NULL;
        } elseif($_GET['action'] == 'edit') {
            // Action - Edit user
            // Forwording to edit page and add parameters
            echo '<script>window.location.replace("editUser.php?id=' . $_GET['id'] . '");</script>';
        }
    }
?>

<p>
    <input type="text" id="filterInput-tableUser" onkeyup="filterData(&quot;tableUser&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn->freeRun(
        'SELECT '
        . 'T_User.id, T_User.id AS userId, name, isAdmin, isDeveloper, isMaintainer, isSupplier, isInspector, login, supplierId '
        . 'FROM `T_User` '
        . 'LEFT JOIN `T_UserPermission` ON `T_UserPermission`.`userId` = `T_User`.`id` '
        . 'LEFT JOIN `T_UserLogin` ON `T_UserLogin`.`userId` = `T_User`.`id`');
    $conn -> dbDisconnect();
    $conn = NULL;

    dataTable_BioManager::showWithUserActions(
        $result,
        'dataTable-tableUser',
        array('name', 'login', 'isAdmin', 'isDeveloper', 'isMaintainer', 'isInspector', 'isSupplier', 'supplierId'),
        array('Name', 'Anmeldename', 'Administrator', 'Entwickler', 'Pfleger', 'Prüfer', 'Lieferant', 'Lieferanten-Nr', 'Aktionen'));

    include 'modules/footer.php';
?>