<?php
/*
* recipient.php
* -------------
* This page shows all recipients in a table. A filter can
* be used to find the wanted rows. With maintainer permissions
* the user can delete, edit and add a recipient.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isMaintainer() && !isInspector()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';
    
    include 'modules/dataTable_BioManager.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>

<h1>Abnehmer</h1>
<p>
    <?php if(isMaintainer()) {?><a href="addRecipient.php">Abnehmer hinzufügen</a><?php } ?>  
</p>

<?php
    if(isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
        if($_GET['action'] == 'delete') {
            // Action - Delete
            echo '<script>window.location.replace("deleteRecipient.php?id=' . $_GET['id'] . '");</script>';
        } elseif($_GET['action'] == 'edit') {
            // Action - Edit
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editRecipient.php?id=' . $_GET['id'] . '");</script>';
        }
    }
?>

<p>
    <input type="text" id="filterInput-tableRecipient" onkeyup="filterData(&quot;tableRecipient&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select('T_Recipient', '*');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataTable_BioManager::showWithDefaultActions(
            $result,
            'dataTable-tableRecipient',
            array('name', 'address'),
            array('Name', 'Adresse', 'Aktionen'));
    } else {
        dataTable_BioManager::show(
            $result,
            'dataTable-tableRecipient',
            array('name', 'address'),
            array('Name', 'Adresse'));
    }

    include 'modules/footer.php';
?>