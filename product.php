<?php
/*
* products.php
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
        // Action - Delete product
        if($_GET['action'] == 'delete') {
            $conn = new Mysql();
            $conn -> dbConnect();
            $conn -> select('T_Product', 'id, name', 'id = ' . $_GET['id']);
            $row = $conn -> getFirstRow();
            
            // Check if id is valid 
            if (is_null($row)) {
                echo '<div class="warning">';
                echo 'Das ausgewählte Produkt wurde in der Datenbank nicht gefunden';
                echo '</div>';
            } else {
                // Delete product 
                $conn -> delete('T_Product', 'id=' . $row['id']);
                
                echo '<div class="infobox">';
                echo 'Das Produkt <strong>' . $row['name'] . '</strong> wurde gelöscht.';
                echo '</div>';
            }
            $conn -> dbDisconnect();
            $conn = NULL;
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