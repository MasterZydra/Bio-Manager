<?php
/*
* deliveryNote.php
* ----------------
* This page shows all delivery notes in a table. A filter can
* be used to find the wanted rows. With maintainer permission
* the user can delete and edit a delivery note.
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

<h1>Lieferschein</h1>

<p>
    <?php if(isMaintainer()) {?><a href="addDeliveryNote.php">Lieferschein hinzufügen</a><?php } ?>
</p>

<?php
    if(isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
        // Action - Delete vendor
        if($_GET['action'] == 'delete') {
            $conn = new Mysql();
            $conn -> dbConnect();
            $result = $conn -> select('T_DeliveryNote', 'id', 'id = ' . $_GET['id']);
            
            // Check if id is valid 
            if ($result->num_rows == 0) {
                echo '<div class="warning">';
                echo 'Der ausgewählte Lieferschein wurde in der Datenbank nicht gefunden';
                echo '</div>';
            } else {
                // Delete vendor 
                $row = $result->fetch_assoc();
                $conn -> freeRun('DELETE FROM T_DeliveryNote WHERE id=' . $row['id']);
                
                echo '<div class="infobox">';
                echo 'Der Lieferschein wurde gelöscht.';
                echo '</div>';
            }
            $conn -> dbDisconnect();
            $conn = NULL;
        } elseif($_GET['action'] == 'edit') {
            // Action - Edit vendor
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editDeliveryNote.php?id=' . $_GET['id'] . '");</script>';
        }
    }
?>

<p>
    <input type="text" id="filterInput-tableDeliveryNote" onkeyup="filterData(&quot;tableDeliveryNote&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select('T_DeliveryNote', '*', NULL, 'year DESC, nr ASC');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataTable_BioManager::showWithDefaultActions(
            $result,
            'dataTable-tableDeliveryNote',
            array('year', 'nr', 'deliverDate', 'amount'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Aktionen'));
    } else {
        dataTable_BioManager::show(
            $result,
            'dataTable-tableDeliveryNote',
            array('year', 'nr', 'deliverDate', 'amount'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge'));
    }

    include 'modules/footer.php';
?>