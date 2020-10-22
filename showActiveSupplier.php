<?php
/*
* showActiveSupplier.php
* ----------------------
* Show all active suppliers in an PDF.
*
* @Author: David Hein
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isMaintainer() && !isInspector())
    {
        header("Location: deliveryNote.php");
        exit();
    }

    // Check if file exists to prevent warnings
    if (file_exists('config/InvoiceDataConfig.php'))
        include 'config/InvoiceDataConfig.php';

    $docName = "Aktive Lieferanten";
    $activeSuppliers = '';

    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select('T_Supplier', 'name', 'inactive = 0');
    $conn -> dbDisconnect();
    $conn = NULL;

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $activeSuppliers .= '<li>' . $row["name"] . '</li>';
        }
    }

$html = '
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
<tr><td width="100%">
    <h1 style="text-align: center;">Aktive Lieferanten</h1>
    <p>
        <ul>' . $activeSuppliers . '</ul>
    </p>
    <p>
        Stand: ' . date("d.m.Y") . '
    </p>
</td></tr> 
</table>';

    // Generate and show PDF document
    // ------------------------------
    include 'modules/pdfGenerator.php';

    $pdfGen = new pdfGenerator();
    $pdfGen -> createPDF($invoice["author"], $docName, $docName, $html);
    $pdfGen -> showInBrowser($docName . '_' . date('Y_m_d'));

?>