<?php
/*
* pricing.php
* -----------
* This page shows all prices in a table.
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

<h1>Preis</h1>

<p>
    <?php if(isMaintainer()) {?><a href="addPricing.php">Preis hinzufügen</a><?php } ?>
</p>

<?php
    if(isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
        if($_GET['action'] == 'delete') {
            // Action - Delete
            echo '<script>window.location.replace("deletePricing.php?id=' . $_GET['id'] . '");</script>';
        } elseif($_GET['action'] == 'edit') {
            // Action - Edit a pricing
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editPricing.php?id=' . $_GET['id'] . '");</script>';
        }
    }
?>

<p>
    <input type="text" id="filterInput-tableData" onkeyup="filterData(&quot;tableData&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
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
        dataTable_BioManager::showWithDefaultActions(
            $result,
            'dataTable-tableDeliveryNote',
            array('productName', 'year', 'price', 'pricePayOut'),
            array('Produkt', 'Jahr', 'Preis', 'Auszahlung', 'Aktionen'));
    } else {
        dataTable_BioManager::show(
            $result,
            'dataTable-tableDeliveryNote',
            array('productName', 'year', 'price', 'pricePayOut'),
            array('Produkt', 'Jahr', 'Preis', 'Auszahlung'));
    }
?>
<script>
    function formatTableCellRight(tableName, colId) {
        var tableRef = document.getElementById(tableName);
        for(var i = 1; i < tableRef.rows.length; i++) {
            tableRef.rows[i].cells[colId].setAttribute("style", "text-align: right");
        }
    }
    
    formatTableCellRight("dataTable-tableDeliveryNote", 2);
    formatTableCellRight("dataTable-tableDeliveryNote", 3);
</script>
<?php
    include 'modules/footer.php';
?>