<?php
/*
* pricing.php
* -----------
* This page shows all prices in a table.
*
* @Author: David Hein
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isMaintainer() && !isInspector() ||
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

<h1>Preis</h1>

<p>
    <?php if(isMaintainer()) {?><a href="addPricing.php">Preis hinzufügen</a><?php } ?>
</p>

<?php
    if(isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
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
    <input type="text" id="filterInput-tablePricing" onkeyup="filterData(&quot;tablePricing&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_Pricing LEFT JOIN T_Product ON T_Product.id = productId',
        'T_Pricing.id, year, FORMAT(price, 2) AS price, FORMAT(pricePayOut, 2) AS pricePayOut, T_Product.name AS productName',
        NULL,
        'T_Product.name ASC, year DESC');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        tableGenerator::show(
            'dataTable-tablePricing',
            $result,
            array('productName', 'year', ['price', 'currency'], ['pricePayOut', 'currency']),
            array('Produkt', 'Jahr', 'Preis', 'Auszahlung', 'Aktionen'),
            array('edit', 'delete'),
            array('Bearbeiten', 'Löschen'));
    } else {
        tableGenerator::show(
            'dataTable-tablePricing',
            $result,
            array('productName', 'year', ['price', 'currency'], ['pricePayOut', 'currency']),
            array('Produkt', 'Jahr', 'Preis', 'Auszahlung'));
    }

    include 'modules/footer.php';
?>