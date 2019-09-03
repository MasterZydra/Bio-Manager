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
        if($_GET['action'] == 'delete') {
            // Action - Delete supplier
            echo '<script>window.location.replace("deleteDeliveryNote.php?id=' . $_GET['id'] . '");</script>';
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
        'T_DeliveryNote '
        . 'LEFT JOIN T_Supplier ON T_Supplier.id = supplierId '
        . 'LEFT JOIN T_Product ON T_Product.id = productId',
        'T_DeliveryNote.id, year, nr, amount, deliverDate, T_Supplier.name AS supplierName, T_Product.name AS productName',
        NULL,
        'year DESC, nr DESC');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataTable_BioManager::showWithDeliveryNoteDefaultActions(
            $result,
            'dataTable-tableDeliveryNote',
            array('year', 'nr', 'deliverDate', 'amount', 'supplierName', 'productName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Lieferant', 'Produkt', 'Aktionen'));
    } else {
        dataTable_BioManager::show(
            $result,
            'dataTable-tableDeliveryNote',
            array('year', 'nr', 'deliverDate', 'amount', 'supplierName', 'productName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Lieferant', 'Produkt'));
    }
?>
<script>
    function formatTableCellRight(tableName, colId) {
        var tableRef = document.getElementById(tableName);
        for(var i = 1; i < tableRef.rows.length; i++) {
            tableRef.rows[i].cells[colId].setAttribute("style", "text-align: right");
        }
    }
    
    formatTableCellRight("dataTable-tableDeliveryNote", 1);
    formatTableCellRight("dataTable-tableDeliveryNote", 3);
</script>
<?php
    include 'modules/footer.php';
?>