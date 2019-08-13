<?php
/*
* deliveryNote.php
* ----------------
* This page shows all delivery notes in a table. A filter can
* be used to find the wanted rows. With maintainer permission
* the user can delete and edit a delivery note.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isMaintainer()) {
        header("Location: vendor.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/helperFunctions.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>

<h1>Lieferschein</h1>

<!--<p>
    <a href="addDeliveryNote.php">Lieferschein hinzufügen</a>    
</p>-->

<?php
    if(isset($_GET['action']) && isset($_GET['id'])) {
        // Action - Delete vendor
        if($_GET['action'] == 'delete') {
            $conn = new Mysql();
            $conn -> dbConnect();
            $result = $conn->selectWhere('T_DeliveryNote', 'id', '=', $_GET['id'], 'int');
            
            // Check if id is valid 
            if ($result->num_rows == 0) {
                echo '<div class="warning">';
                echo 'Der ausgewählte Lieferschein wurde in der Datenbank nicht gefunden';
                echo '</div>';
            } else {
                // Delete vendor 
                $row = $result->fetch_assoc();
                $conn -> selectFreeRun('DELETE FROM T_DeliveryNote WHERE id=' . $row['id']);
                
                echo '<div class="infobox">';
                echo 'Der Lieferschein wurde gelöscht.';
                echo '</div>';
            }
            $conn -> dbDisconnect();
            $conn = NULL;
        } elseif($_GET['action'] == 'edit') {
            // Action - Edit vendor
            // Forwording to edit page and add parameters
            //echo '<script>window.location.replace("editVendor.php?id=' . $_GET['id'] . '");</script>';
        }
    }
?>

<p>
    <input type="text" id="filterInput-tableDeliveryNote" onkeyup="filterData(&quot;tableDeliveryNote&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn->selectOrderBy('T_DeliveryNote', 'year DESC, nr ASC');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataSetToTableWithDropdown($result,
            array('year', 'nr', 'deliverDate', 'amount'),
            'dataTable-tableDeliveryNote',
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Aktionen'));
    } else {
        dataSetToTable(
            $result,
            array('year', 'nr', 'deliverDate', 'amount'),
            'dataTable-tableDeliveryNote',
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge'));
    }

    include 'modules/footer.php';
?>