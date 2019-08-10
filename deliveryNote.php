<?php
    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';
    include 'modules/header.php';

    include 'modules/helperFunctions.php';
    ?>
<script src="js/filterDataTable.js"></script>

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
    
    dataSetToTable($result, array('year', 'nr', 'deliverDate', 'amount'), 'dataTable-tableDeliveryNote', array('Jahr', 'Nr', 'Lieferdatum', 'Menge'));
    
    $conn->dbDisconnect();
    
    include 'modules/footer.php';
    ?>
