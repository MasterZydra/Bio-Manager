<?php
/*
* supplier.php
* ----------------
* This page shows all suppliers in a table. A filter can
* be used to find the wanted rows. With maintainer permissions
* the user can delete, edit and add a supplier.
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
    
    include 'modules/helperFunctions.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>

<h1>Lieferant</h1>
<p>
    <a href="addSupplier.php">Lieferant hinzufügen</a>    
</p>

<?php
    if(isset($_GET['action']) && isset($_GET['id'])) {
        // Action - Delete vendor
        if($_GET['action'] == 'delete') {
            $conn = new Mysql();
            $conn -> dbConnect();
            $result = $conn->selectWhere('T_Supplier', 'id', '=', $_GET['id'], 'int');
            
            // Check if id is valid 
            if ($result->num_rows == 0) {
                echo '<div class="warning">';
                echo 'Der ausgewählte Lieferant wurde in der Datenbank nicht gefunden';
                echo '</div>';
            } else {
                // Delete vendor 
                $row = $result->fetch_assoc();
                $conn -> freeRun('DELETE FROM T_Supplier WHERE id=' . $row['id']);
                
                echo '<div class="infobox">';
                echo 'Der Lieferant <strong>' . $row['name'] . '</strong> wurde gelöscht.';
                echo '</div>';
            }
            $conn -> dbDisconnect();
            $conn = NULL;
        } elseif($_GET['action'] == 'edit') {
            // Action - Edit vendor
            // Forwording to edit page and add parameters
            echo '<script>window.location.replace("editSupplier.php?id=' . $_GET['id'] . '");</script>';
        }
    }
?>

<p>
    <input type="text" id="filterInput-tableSupplier" onkeyup="filterData(&quot;tableSupplier&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> selectAll('T_Supplier');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataSetToTableWithDropdown($result, array('id', 'name'), 'dataTable-tableSupplier', array('Lieferant-Nr.', 'Name', 'Aktionen'));
    } else {
        dataSetToTable($result, array('id', 'name'), 'dataTable-tableSupplier', array('Lieferant-Nr.', 'Name'));
    }

    include 'modules/footer.php';
?>