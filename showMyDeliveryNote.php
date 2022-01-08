<?php
/*
* showMyDeliveryNote.php
* ----------------------
* Page to show the delivery notes of an user
* who is also an supplier.
*
* @Author: David Hein
*/

include 'modules/header_user.php';
include 'modules/permissionCheck.php';

// Check permission
if (!isSupplier()) {
    header("Location: index.php");
    exit();
}

include 'modules/header.php';

include 'modules/tableGenerator.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>

<h1>Meine Lieferscheine</h1>

<p>
    <?php if (isMaintainer() || isInspector()) {?>
    <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>
    <?php } if (isMaintainer()) {?>
    <br><a href="addDeliveryNote.php">Lieferschein hinzufügen</a>
    <?php } ?>
</p>

<?php
if (isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
    if (secGET('action') == 'delete') {
        // Action - Delete supplier
        echo '<script>window.location.replace("deleteDeliveryNote.php?id=' . secGET('id') . '");</script>';
    } elseif (secGET('action') == 'edit') {
        // Action - Edit a delivery note
        // Forwarding to edit page and add parameters
        echo '<script>window.location.replace("editDeliveryNote.php?id=' . secGET('id') . '");</script>';
    } elseif (secGET('action') == 'volDist') {
        // Action - Edit volume distribution of a delivery note
        // Forwarding to edit page and add parameters
        echo '<script>window.location.replace("editCropVolumeDistribution.php?id=' . secGET('id') . '");</script>';
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
        . 'LEFT JOIN T_Product ON T_Product.id = productId',
        'T_DeliveryNote.id, year, nr, amount, deliverDate, T_Product.name AS productName',
        'supplierId = ' . getUserSupplierId(),
        'year DESC, nr DESC'
    );
    $conn -> dbDisconnect();
    $conn = null;

    if (isMaintainer()) {
        tableGenerator::show(
            'dataTable-tableDeliveryNote',
            $result,
            array('year', ['nr', 'int'], ['deliverDate', 'date'], ['amount', 'int'], 'productName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Produkt', 'Aktionen'),
            array('edit', 'volDist'),
            array('Bearbeiten', 'Mengenverteilung')
        );
    } else {
        tableGenerator::show(
            'dataTable-tableDeliveryNote',
            $result,
            array('year', ['nr', 'int'], ['deliverDate', 'date'], ['amount', 'int'], 'productName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Produkt')
        );
    }

    include 'modules/footer.php';
    ?>