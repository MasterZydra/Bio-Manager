<?php
/*
* supplier.php
* ----------------
* This page shows all suppliers in a table. A filter can
* be used to find the wanted rows. With maintainer permissions
* the user can delete, edit and add a supplier.
*
* @Author: David Hein
*/

    include 'modules/header_user.php';
    include 'modules/PermissionCheck.php';

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

    include 'modules/TableGenerator.php';
    include_once 'System/Modules/DataObjects/SupplierCollection.php';

?>

<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>
<script src="js/sortDataTable.js"></script>

<h1>Lieferant</h1>
<p>
    <?php if (isMaintainer()) {
        ?><a href="addSupplier.php">Lieferant hinzufügen</a><?php
    } ?>  
</p>

<?php
if (isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
    switch (secGET('action')) {
        case 'delete':
            // Action - Delete
            echo '<script>window.location.replace("deleteSupplier.php?id=' . secGET('id') . '");</script>';
            break;
        case 'edit':
            // Action - Edit vendor
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editSupplier.php?id=' . secGET('id') . '");</script>';
            break;
    }
}
?>

<p>
    <input type="text" id="filterInput-tableSupplier"
    onkeyup="filterData(&quot;tableSupplier&quot;)" 
    placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $supplierColl = new SupplierCollection();

if (isMaintainer()) {
    TableGenerator::show(
        'dataTable-tableSupplier',
        $supplierColl->findAll(),
        array('name', ['inactive', 'bool']),
        array('Name', 'Inaktiv', 'Aktionen'),
        array('edit', 'delete'),
        array('Bearbeiten', 'Löschen')
    );
} else {
    TableGenerator::show(
        'dataTable-tableSupplier',
        $supplierColl->findAll(),
        array('name', ['inactive', 'bool']),
        array('Name', 'Inaktiv')
    );
}
?>

<script>
    // Order by name
    sortTable("dataTable-tableSupplier", 0);
    // Order by inactive desc
    sortTable("dataTable-tableSupplier", 1, true);
</script>

<?php
    include 'modules/footer.php';
?>