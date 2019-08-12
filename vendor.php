<?php
    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isMaintainer()) {
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
    <a href="addVendor.php">Lieferant hinzufügen</a>    
</p>

<?php
    if(isset($_GET['action']) && isset($_GET['id'])) {
        // Action - Delete vendor
        if($_GET['action'] == 'delete') {
            $conn = new Mysql();
            $conn -> dbConnect();
            $result = $conn->selectWhere('T_Vendor', 'id', '=', $_GET['id'], 'int');
            
            // Check if id is valid 
            if ($result->num_rows == 0) {
                echo '<div class="warning">';
                echo 'Der ausgewählte Lieferant wurde in der Datenbank nicht gefunden';
                echo '</div>';
            } else {
                // Delete vendor 
                $row = $result->fetch_assoc();
                $conn -> selectFreeRun('DELETE FROM T_Vendor WHERE id=' . $row['id']);
                
                echo '<div class="infobox">';
                echo 'Der Lieferant <strong>' . $row['name'] . '</strong> wurde gelöscht.';
                echo '</div>';
            }
            $conn -> dbDisconnect();
            $conn = NULL;
        } elseif($_GET['action'] == 'edit') {
            // Action - Edit vendor
            // Forwording to edit page and add parameters
            echo '<script>window.location.replace("editVendor.php?id=' . $_GET['id'] . '");</script>';
        }
    }
?>

<p>
    <input type="text" id="filterInput-tableVendors" onkeyup="filterData(&quot;tableVendors&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> selectAll('T_Vendor');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataSetToTableWithDropdown($result, array('id', 'name'), 'dataTable-tableVendors', array('Lieferant-Nr.', 'Name', 'Aktionen'));
    } else {
        dataSetToTable($result, array('id', 'name'), 'dataTable-tableVendors', array('Lieferant-Nr.', 'Name'));
    }

    include 'modules/footer.php';
?>