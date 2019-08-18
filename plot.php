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
        // Action - Delete vendor
        if($_GET['action'] == 'delete') {
            $conn = new Mysql();
            $conn -> dbConnect();
            $result = $conn -> select('T_Plot', 'id', 'id = ' . $_GET['id']);
            
            // Check if id is valid 
            if ($result->num_rows == 0) {
                echo '<div class="warning">';
                echo 'Das ausgewählte Flurstück wurde in der Datenbank nicht gefunden';
                echo '</div>';
            } else {
                // Delete vendor 
                $row = $result->fetch_assoc();
                $conn -> freeRun('DELETE FROM T_Plot WHERE id=' . $row['id']);
                
                echo '<div class="infobox">';
                echo 'Das Flurstück wurde gelöscht.';
                echo '</div>';
            }
            $conn -> dbDisconnect();
            $conn = NULL;
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
    $result = $conn -> select('T_Plot');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataTable_BioManager::showWithDefaultActions(
            $result,
            'dataTable-tablePlot',
            array('nr', 'name', 'subdistrict'),
            array('Nummer', 'Name', 'Gemarkung', 'Aktionen'));
    } else {
        dataTable_BioManager::show(
            $result,
            'dataTable-tablePlot',
            array('nr', 'name', 'subdistrict'),
            array('Nummer', 'Name', 'Gemarkung'));
    }

    include 'modules/footer.php';
?>