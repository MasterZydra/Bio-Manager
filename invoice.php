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
    if(!isMaintainer() && !isInspector() ||
       // Check if id is numeric
       (isset($_GET['id']) && !is_numeric($_GET['id'])))
    {
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
    <?php if(isMaintainer()) {?><a href="addInvoice.php">Rechnung hinzufügen</a><?php } ?>
</p>

<?php
    if(isset($_GET['action']) && isset($_GET['id'])) {
        if(secGET('action') == 'show') {
            // Action - show selected invoice
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("showInvoice.php?id=' . secGET('id') . '");</script>';
        } elseif(isMaintainer() && secGET('action') == 'delete') {
            // Action - Delete invoice
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("deleteInvoice.php?id=' . secGET('id') . '");</script>';
        } elseif(isMaintainer() && secGET('action') == 'edit') {
            // Action - Edit invoice
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editInvoice.php?id=' . secGET('id') . '");</script>';
        }  
    }
?>

<p>
    <input type="text" id="filterInput-tableInvoice" onkeyup="filterData(&quot;tableInvoice&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_Invoice LEFT JOIN T_Recipient ON T_Invoice.recipientId = T_Recipient.id',
        'T_Invoice.id, year, nr, invoiceDate, isPaid, name',
        NULL,
        'year DESC, nr DESC');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataTable_BioManager::showWithInvoiceDefaultActions(
            $result,
            'dataTable-tableInvoice',
            array('year', 'nr', 'invoiceDate', 'isPaid', 'name'),
            array('Jahr', 'Nr', 'Datum', 'Bezahlt', 'Abnehmer', 'Aktionen'));
    } else {
        dataTable_BioManager::showWithInvoiceActions(
            $result,
            'dataTable-tableInvoice',
            array('year', 'nr', 'invoiceDate', 'isPaid', 'name'),
            array('Jahr', 'Nr', 'Datum', 'Bezahlt', 'Abnehmer', 'Aktionen'));
    }

    include 'modules/footer.php';
?>