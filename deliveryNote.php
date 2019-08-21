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
                $conn -> delete('T_DeliveryNote', 'id=' . $row['id']);
                
                echo '<div class="infobox">';
                echo 'Der Lieferschein wurde gelöscht.';
                echo '</div>';
            }
            $conn -> dbDisconnect();
            $conn = NULL;
        } elseif($_GET['action'] == 'edit') {
            // Action - Edit a delivery note
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editDeliveryNote.php?id=' . $_GET['id'] . '");</script>';
        } elseif($_GET['action'] == 'volDist') {
            // Action - Edit volume distribution of a delivery note
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editCropVolumeDistribution.php?id=' . $_GET['id'] . '");</script>';
        }
    }
?>

<p>
    <input type="text" id="filterInput-tableDeliveryNote" onkeyup="filterData(&quot;tableDeliveryNote&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_DeliveryNote LEFT JOIN T_Supplier ON T_Supplier.id = supplierId',
        'T_DeliveryNote.id, year, nr, amount, deliverDate, T_Supplier.name AS supplierName',
        NULL,
        'year DESC, nr DESC');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataTable_BioManager::showWithDeliveryNoteActions(
            $result,
            'dataTable-tableDeliveryNote',
            array('year', 'nr', 'deliverDate', 'amount', 'supplierName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Lieferant', 'Aktionen'));
    } else {
        dataTable_BioManager::show(
            $result,
            'dataTable-tableDeliveryNote',
            array('year', 'nr', 'deliverDate', 'amount', 'supplierName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Lieferant'));
    }

    include 'modules/footer.php';
?>