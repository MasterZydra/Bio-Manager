<?php
    include 'modules/header.php';
?>
<script src="js/filterDataTable.js"></script>

<h1>Lieferanten</h1>


<p>
    <a href="addVendorForm">Lieferant hinzufügen</a>    
</p>
<p>
    <input type="text" id="filterInput-tableVendors" onkeyup="filterData(&quot;tableVendors&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    include 'modules/Mysql.php';
    include 'modules/helperFunctions.php';

    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn->selectAll('T_Vendor');

    dataSetToTable($result, array('id', 'name'), 'dataTable-tableVendors', array('Lieferant-Nr.', 'Name'));

    $conn->dbDisconnect();

    include 'modules/footer.php';
?>