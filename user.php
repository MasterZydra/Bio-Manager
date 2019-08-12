<?php
    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isAdmin()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/helperFunctions.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>

<h1>Benutzer</h1>

<?php
    if(isset($_GET['action']) && isset($_GET['id'])) {
        // Action - Delete vendor
        if($_GET['action'] == 'delete') {
            $conn = new Mysql();
            $conn -> dbConnect();
            $result = $conn->selectWhere('T_User', 'id', '=', $_GET['id'], 'int');
            
            // Check if id is valid 
            if ($result->num_rows == 0) {
                echo '<div class="warning">';
                echo 'Der ausgewählte Benutzer wurde in der Datenbank nicht gefunden';
                echo '</div>';
            } else {
                // Delete vendor 
                $row = $result->fetch_assoc();
                $conn -> selectFreeRun('DELETE FROM T_User WHERE id=' . $row['id']);
                $conn -> selectFreeRun('DELETE FROM T_UserLogin WHERE userId=' . $row['id']);
                $conn -> selectFreeRun('DELETE FROM T_UserPermission WHERE userId=' . $row['id']);
                
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

<!--<p>
    <a href="addDeliveryNote.php">Lieferschein hinzufügen</a>    
</p>-->
<p>
    <input type="text" id="filterInput-tableUser" onkeyup="filterData(&quot;tableUser&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn->selectFreeRun(
        'SELECT '
        . 'T_User.id, T_User.id AS userId, name, isAdmin, isDeveloper, isMaintainer, isVendor, isInspector, login, vendorId '
        . 'FROM `T_User` '
        . 'LEFT JOIN `T_UserPermission` ON `T_UserPermission`.`userId` = `T_User`.`id` '
        . 'LEFT JOIN `T_UserLogin` ON `T_UserLogin`.`userId` = `T_User`.`id`');
    $conn -> dbDisconnect();
    $conn = NULL;

    dataSetToTableWithDropdown($result,
        array('name', 'login', 'isAdmin', 'isDeveloper', 'isMaintainer', 'isInspector', 'isVendor', 'vendorId'),
        'dataTable-tableUser',
        array('Name', 'Anmeldename', 'Administrator', 'Entwickler', 'Pfleger', 'Prüfer', 'Lieferant', 'Lieferanten-Nr', 'Aktionen'));

    include 'modules/footer.php';
?>