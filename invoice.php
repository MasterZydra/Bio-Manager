<?php
/*
* invoice.php
* ----------------
* This page shows all invoices.
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
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/dataTable_BioManager.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>

<h1>Rechnung</h1>
<p>
    <a href="addInvoice.php">Rechnung hinzufügen</a>    
</p>

<p>
    <input type="text" id="filterInput-tableInvoice" onkeyup="filterData(&quot;tableInvoice&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select('T_Invoice', '*', NULL, 'year DESC, nr ASC');
    $conn -> dbDisconnect();
    $conn = NULL;

    dataTable_BioManager::show(
        $result,
        'dataTable-tableInvoice',
        array('year', 'nr', 'invoiceDate', 'isPaid'),
        array('Jahr', 'Nr', 'Datum', 'Bezahlt'));

    include 'modules/footer.php';
?>