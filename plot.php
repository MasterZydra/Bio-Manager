<?php
/*
* Plot.php
* ----------------
* This page shows all plots in a table. A filter can
* be used to find the wanted rows. With maintainer permission
* the user can delete and edit a plot.
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

include 'modules/TableGenerator.php';
include_once 'system/modules/dataObjects/plotCollection.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>
<script src="js/sortDataTable.js"></script>

<h1>Flurstück</h1>

<p>
    <?php if (isMaintainer()) {
        ?><a href="addPlot.php">Flurstück hinzufügen</a><?php
    } ?>
</p>

<?php
if (isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
    switch (secGET('action')) {
        case 'delete':
            // Action - Delete
            echo '<script>window.location.replace("deletePlot.php?id=' . secGET('id') . '");</script>';
            break;
        case 'edit':
            // Action - Edit plot
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editPlot.php?id=' . secGET('id') . '");</script>';
            break;
    }
}
?>

<p>
    <input type="text" id="filterInput-tablePlot" placeholder="Suchtext eingeben..." title="Suchtext"
    onkeyup="filterData(&quot;tablePlot&quot;)" />
</p>

<?php
    $plotColl = new PlotCollection();

if (isMaintainer()) {
    TableGenerator::show(
        'dataTable-tablePlot',
        $plotColl->findAll(),
        array('nr', 'name', 'subdistrict', 'supplierName'),
        array('Nummer', 'Name', 'Gemarkung', 'Lieferant', 'Aktionen'),
        array('edit', 'delete'),
        array('Bearbeiten', 'Löschen')
    );
} else {
    TableGenerator::show(
        'dataTable-tablePlot',
        $plotColl->findAll(),
        array('nr', 'name', 'subdistrict', 'supplierName'),
        array('Nummer', 'Name', 'Gemarkung', 'Lieferant')
    );
}
?>

<script>
    // Order by plot nr
    sortTable("dataTable-tablePlot", 0);
</script>

<?php
    include 'modules/footer.php';
?>