<?php
/*
* deliveryNote.php
* ----------------
* This page shows all delivery notes in a table. A filter can
* be used to find the wanted rows. With maintainer permission
* the user can delete and edit a delivery note.
*
* @Author: David Hein
*/
include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';
// Check permission
if (
    !isMaintainer() && !isInspector() ||
        // Check if id is numeric
        (isset($_GET['id']) && !is_numeric($_GET['id']))
) {
    header("Location: index.php");
    exit();
}
include 'Modules/header.php';

include 'Modules/TableGenerator.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>

<h1>Lieferschein</h1>

<p>
    <?php if (isMaintainer()) {
        ?><a href="addDeliveryNote.php">Lieferschein hinzufügen</a><?php
    } ?>
</p>

<?php
if (isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
    switch (secGET('action')) {
        case 'delete':
            // Action - Delete supplier
            echo '<script>window.location.replace("deleteDeliveryNote.php?id=' . secGET('id') . '");</script>';
            break;
        case 'edit':
            // Action - Edit a delivery note
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editDeliveryNote.php?id=' . secGET('id') . '");</script>';
            break;
        case 'volDist':
            // Action - Edit volume distribution of a delivery note
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editCropVolumeDistribution.php?id=' . secGET('id') . '");</script>';
            break;
    }
}
?>

<p>
    <input type="text" id="filterInput-tableDeliveryNote" placeholder="Suchtext eingeben..." title="Suchtext"
    onkeyup="filterData(&quot;tableDeliveryNote&quot;)" /> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_DeliveryNote '
        . 'LEFT JOIN T_Supplier ON T_Supplier.id = supplierId '
        . 'LEFT JOIN T_Product ON T_Product.id = productId',
        'T_DeliveryNote.id, year, nr, amount, deliverDate, '
        . 'T_Supplier.name AS supplierName, T_Product.name AS productName',
        null,
        'year DESC, nr DESC'
    );
    $conn -> dbDisconnect();
    $conn = null;
    if (isMaintainer()) {
        TableGenerator::show(
            'dataTable-tableDeliveryNote',
            $result,
            array('year', ['nr', 'int'], ['deliverDate', 'date'], ['amount', 'int'], 'supplierName', 'productName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Lieferant', 'Produkt', 'Aktionen'),
            array('edit', 'volDist', 'delete'),
            array('Bearbeiten', 'Mengenverteilung', 'Löschen')
        );
    } else {
        TableGenerator::show(
            'dataTable-tableDeliveryNote',
            $result,
            array('year', ['nr', 'int'], ['deliverDate', 'date'], ['amount', 'int'], 'supplierName', 'productName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Lieferant', 'Produkt')
        );
    }

    include 'Modules/footer.php';
    ?>