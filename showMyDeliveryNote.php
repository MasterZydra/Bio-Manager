<?php
/*
* showMyDeliveryNote.php
* ----------------------
* Page to show the delivery notes of an user
* who is also an supplier.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isSupplier()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/dataTable_BioManager.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>

<h1>Meine Lieferscheine</h1>

<p>
    <?php if(isMaintainer() || isInspector()) {?>
    <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>
    <?php } if(isMaintainer()) {?>
    <br><a href="addDeliveryNote.php">Lieferschein hinzufügen</a>
    <?php } ?>
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
        . 'LEFT JOIN T_Product ON T_Product.id = productId',
        'T_DeliveryNote.id, year, nr, amount, deliverDate, T_Product.name AS productName',
        'supplierId = ' . getUserSupplierId(),
        'year DESC, nr DESC');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataTable_BioManager::showWithDeliveryNoteDefaultActions(
            $result,
            'dataTable-tableDeliveryNote',
            array('year', 'nr', 'deliverDate', 'amount', 'productName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Produkt', 'Aktionen'),
            array('', 'int', 'date', 'int', ''));
    } else {
        dataTable_BioManager::show(
            $result,
            'dataTable-tableDeliveryNote',
            array('year', 'nr', 'deliverDate', 'amount', 'productName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Produkt'),
            false,
            false,
            array('', 'int', 'date', 'int', ''));
    }

    include 'modules/footer.php';
?>