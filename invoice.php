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

<?php
    if(isset($_GET['action']) && $_GET['action'] == 'show') {
        // Action - show selected invoice
        // Forwarding to edit page and add parameters
        echo '<script>window.location.replace("showInvoice.php?id=' . $_GET['id'] . '");</script>';
    }
?>

<p>
    <input type="text" id="filterInput-tableInvoice" onkeyup="filterData(&quot;tableInvoice&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select('T_Invoice', '*', NULL, 'year DESC, nr ASC');
    $conn -> dbDisconnect();
    $conn = NULL;

    dataTable_BioManager::showWithInvoiceActions(
        $result,
        'dataTable-tableInvoice',
        array('year', 'nr', 'invoiceDate', 'isPaid'),
        array('Jahr', 'Nr', 'Datum', 'Bezahlt', 'Aktionen'));

    include 'modules/footer.php';
?>