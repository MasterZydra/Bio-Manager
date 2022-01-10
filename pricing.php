<?php
/*
* pricing.php
* -----------
* This page shows all prices in a table.
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

<h1>Preis</h1>

<p>
    <?php if (isMaintainer()) {
        ?><a href="addPricing.php">Preis hinzufügen</a><?php
    } ?>
</p>

<?php
if (isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
    switch (secGET('action')) {
        case 'delete':
            // Action - Delete
            echo '<script>window.location.replace("deletePricing.php?id=' . secGET('id') . '");</script>';
            break;
        case 'edit':
            // Action - Edit a pricing
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editPricing.php?id=' . secGET('id') . '");</script>';
            break;
    }
}
?>

<p>
    <input type="text" id="filterInput-tablePricing" placeholder="Suchtext eingeben..." title="Suchtext"
    onkeyup="filterData(&quot;tablePricing&quot;)" /> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_Pricing LEFT JOIN T_Product ON T_Product.id = productId',
        'T_Pricing.id, year, FORMAT(price, 2) AS price, FORMAT(pricePayOut, 2) AS pricePayOut, '
        . 'T_Product.name AS productName',
        null,
        'T_Product.name ASC, year DESC'
    );
    $conn -> dbDisconnect();
    $conn = null;

    if (isMaintainer()) {
        TableGenerator::show(
            'dataTable-tablePricing',
            $result,
            array('productName', 'year', ['price', 'currency'], ['pricePayOut', 'currency']),
            array('Produkt', 'Jahr', 'Preis', 'Auszahlung', 'Aktionen'),
            array('edit', 'delete'),
            array('Bearbeiten', 'Löschen')
        );
    } else {
        TableGenerator::show(
            'dataTable-tablePricing',
            $result,
            array('productName', 'year', ['price', 'currency'], ['pricePayOut', 'currency']),
            array('Produkt', 'Jahr', 'Preis', 'Auszahlung')
        );
    }

    include 'Modules/footer.php';
    ?>