<?php
/*
* plot.php
* ----------------
* This page shows all plots in a table. A filter can
* be used to find the wanted rows. With maintainer permission
* the user can delete and edit a plot.
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

<h1>Flurstück</h1>

<p>
    <?php if(isMaintainer()) {?><a href="addPlot.php">Flurstück hinzufügen</a><?php } ?>
</p>

<?php
    if(isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
        
        if($_GET['action'] == 'delete') {
            // Action - Delete
            echo '<script>window.location.replace("deletePlot.php?id=' . $_GET['id'] . '");</script>';
        } elseif($_GET['action'] == 'edit') {
            // Action - Edit plot
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editPlot.php?id=' . $_GET['id'] . '");</script>';
        }
    }
?>

<p>
    <input type="text" id="filterInput-tablePlot" onkeyup="filterData(&quot;tablePlot&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_Plot LEFT JOIN T_Supplier ON T_Supplier.id = supplierId',
        'T_Plot.id, nr, T_Plot.name, subdistrict, T_Supplier.name AS supplierName',
        NULL,
        'T_Plot.nr ASC');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataTable_BioManager::showWithDefaultActions(
            $result,
            'dataTable-tablePlot',
            array('nr', 'name', 'subdistrict', 'supplierName'),
            array('Nummer', 'Name', 'Gemarkung', 'Lieferant', 'Aktionen'));
    } else {
        dataTable_BioManager::show(
            $result,
            'dataTable-tablePlot',
            array('nr', 'name', 'subdistrict', 'supplierName'),
            array('Nummer', 'Name', 'Gemarkung', 'Lieferant'));
    }

    include 'modules/footer.php';
?>