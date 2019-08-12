<?php
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