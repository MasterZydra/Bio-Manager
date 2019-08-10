<?php
    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';
    include 'modules/header.php';
    
    include 'modules/helperFunctions.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>

<h1>Lieferanten</h1>

<p>
    <a href="addVendor.php">Lieferant hinzufügen</a>    
</p>
<p>
    <input type="text" id="filterInput-tableVendors" onkeyup="filterData(&quot;tableVendors&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn->selectAll('T_Vendor');
    $conn->dbDisconnect();

    if(isAllowedToEditVendor()) {
        dataSetToTableWithDropdown($result, array('id', 'name'), 'dataTable-tableVendors', array('Lieferant-Nr.', 'Name', 'Aktionen'));
    } else {
        dataSetToTable($result, array('id', 'name'), 'dataTable-tableVendors', array('Lieferant-Nr.', 'Name'));
    }

    include 'modules/footer.php';
?>