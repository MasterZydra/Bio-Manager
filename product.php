<?php
/*
* product.php
* ----------------
* This page shows all products in a table. A filter can
* be used to find the wanted rows. With maintainer permission
* the user can delete and edit a product.
*
* @Author: David Hein
*/

include 'modules/header_user.php';
include 'modules/permissionCheck.php';

// Check permission
if (
    !isMaintainer() && !isInspector() ||
        // Check if id is numeric
        (isset($_GET['id']) && !is_numeric($_GET['id']))
) {
    header("Location: index.php");
    exit();
}

include 'modules/header.php';

include 'modules/tableGenerator.php';
include_once 'system/modules/dataObjects/productCollection.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>
<script src="js/sortDataTable.js"></script>

<h1>Produkt</h1>

<p>
    <?php if (isMaintainer()) {
        ?><a href="addProduct.php">Produkt hinzufügen</a><?php
    } ?>
</p>

<?php
if (isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
    switch (secGET('action')) {
        case 'delete':
            // Action - Delete
            echo '<script>window.location.replace("deleteProduct.php?id=' . secGET('id') . '");</script>';
            break;
        case 'edit':
            // Action - Edit a product
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editProduct.php?id=' . secGET('id') . '");</script>';
            break;
    }
}
?>

<p>
    <input type="text" id="filterInput-tableProduct" onkeyup="filterData(&quot;tableProduct&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $productColl = new ProductCollection();

if (isMaintainer()) {
    tableGenerator::show(
        'dataTable-tableProduct',
        $productColl->findAll(),
        array('name'),
        array('Name', 'Aktionen'),
        array('edit', 'delete'),
        array('Bearbeiten', 'Löschen')
    );
} else {
    tableGenerator::show(
        'dataTable-tableProduct',
        $productColl->findAll(),
        array('name'),
        array('Name')
    );
}
?>

<script>
    // Order by name
    sortTable("dataTable-tableProduct", 0);
</script>

<?php
    include 'modules/footer.php';
?>