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
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isAdmin() ||
       // Check if id is numeric
       (isset($_GET['id']) && !is_numeric($_GET['id'])))
    {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/tableGenerator.php';
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
        switch (secGET('action')) {
            case 'delete':
                // Action - Delete user
                // Forwording to edit page and add parameters
                echo '<script>window.location.replace("deleteUser.php?id=' . secGET('id') . '");</script>';
                break;
            case 'edit':
                // Action - Edit user
                // Forwording to edit page and add parameters
                echo '<script>window.location.replace("editUser.php?id=' . secGET('id') . '");</script>';
                break;
            case 'changePwd':
                // Action - Change user password
                // Forwarding to edit page and add parameters
                echo '<script>window.location.replace("changeUserPwd.php?id=' . secGET('id') . '");</script>';
                break;
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
        . 'T_User.id, T_User.id AS userId, T_User.name, isAdmin, isDeveloper, isMaintainer, isSupplier, isInspector, login, `T_Supplier`.name AS supplierName '
        . 'FROM `T_User` '
        . 'LEFT JOIN `T_UserPermission` ON `T_UserPermission`.`userId` = `T_User`.`id` '
        . 'LEFT JOIN `T_UserLogin` ON `T_UserLogin`.`userId` = `T_User`.`id` '
        . 'LEFT JOIN `T_Supplier` ON `T_Supplier`.`id` = `T_User`.`supplierId` '
        . 'ORDER BY T_User.name ASC');
    $conn -> dbDisconnect();
    $conn = NULL;

    tableGenerator::show(
        'dataTable-tableUser',
        $result,
        array('name', 'login', ['isAdmin', 'bool'], ['isDeveloper', 'bool'],
              ['isMaintainer', 'bool'], ['isInspector', 'bool'],
              ['isSupplier', 'bool'], 'supplierName'),
        array('Name', 'Anmeldename', 'Administrator', 'Entwickler', 'Pfleger',
              'Prüfer', 'Lieferant', 'Lieferanten-Nr', 'Aktionen'),
        array('edit', 'changePwd', 'delete'),
        array('Bearbeiten', 'Passwort ändern', 'Löschen'));

    include 'modules/footer.php';
?>