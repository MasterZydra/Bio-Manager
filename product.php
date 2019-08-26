<?php
/*
* product.php
* ----------------
* This page shows all products in a table. A filter can
* be used to find the wanted rows. With maintainer permission
* the user can delete and edit a product.
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

<h1>Produkt</h1>

<p>
    <?php if(isMaintainer()) {?><a href="addProduct.php">Produkt hinzufügen</a><?php } ?>
</p>

<?php
    if(isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
        if($_GET['action'] == 'delete') {
            // Action - Delete
            echo '<script>window.location.replace("deleteProduct.php?id=' . $_GET['id'] . '");</script>';
        } elseif($_GET['action'] == 'edit') {
            // Action - Edit a product
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editProduct.php?id=' . $_GET['id'] . '");</script>';
        }
    }
?>

<p>
    <input type="text" id="filterInput-tableProduct" onkeyup="filterData(&quot;tableProduct&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_Product',
        '*',
        NULL,
        'name ASC');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataTable_BioManager::showWithDefaultActions(
            $result,
            'dataTable-tableProduct',
            array('name'),
            array('Name', 'Aktionen'));
    } else {
        dataTable_BioManager::show(
            $result,
            'dataTable-tableProduct',
            array('name'),
            array('Name'));
    }

    include 'modules/footer.php';
?>