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

<h1>Lieferant</h1>
<p>
    <?php if(isMaintainer()) {?><a href="addSupplier.php">Lieferant hinzufügen</a><?php } ?>  
</p>

<?php
    if(isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
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
    <input type="text" id="filterInput-tableSupplier" onkeyup="filterData(&quot;tableSupplier&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select('T_Supplier', '*', NULL, 'inactive, name');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        tableGenerator::show(
            'dataTable-tableSupplier',
            $result,
            array('name', ['inactive', 'bool']),
            array('Name', 'Inaktiv', 'Aktionen'),
            array('edit', 'delete'),
            array('Bearbeiten', 'Löschen'));
    } else {
        tableGenerator::show(
            'dataTable-tableSupplier',
            $result,
            array('name', ['inactive', 'bool']),
            array('Name', 'Inaktiv'));
    }

    include 'modules/footer.php';
?>