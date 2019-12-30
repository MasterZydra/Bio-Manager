<?php
/*
* showInvoice.php
* ----------------
* This page generates and shows an invoice.
*
* @Author: David Hein
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isMaintainer() && !isInspector() ||
       // Check if id is set
       !isset($_GET['id']) ||
       // Check if id is numeric
       (isset($_GET['id']) && !is_numeric($_GET['id'])))
    {
        echo "<script>window.close();</script>";
        exit();
    }

    include 'modules/invoice.php';

    // Check if file exists to prevent warnings
    if (file_exists('config/InvoiceDataConfig.php'))
        include 'config/InvoiceDataConfig.php';

    $conn = new Mysql();
    $conn -> dbConnect();
    $conn -> select(
        'T_Invoice LEFT JOIN T_Recipient ON T_Invoice.recipientId = T_Recipient.id',
        'invoiceDate, year, nr, name, address',
        'T_Invoice.id = ' . secGET('id'));
    $row = $conn -> getFirstRow();
    $conn -> dbDisconnect();
    $conn = NULL;

    // Go to invoice overview if no invoice was found
    if (is_null($row)) {
        echo "<script>window.close();</script>";
        exit();
    }

    $inv = new invoice();

    $inv -> invoiceReceiver     = $row['name'] . '<br>' . $row['address'];
    $inv -> invoiceYear         = $row['year'];
    $inv -> invoiceNr           = $row['nr'];
    $inv -> invoiceDate         = date("d.m.Y", strtotime($row['invoiceDate']));

    function formatIBAN($IBAN) {
        $i = 0;
        $ret = "";
        $len = strlen($IBAN);
        while($len - $i > 4) {
            $ret .= substr($IBAN, $i, 4);
            $ret .= " ";
            $i += 4;
        }
        $ret .= substr($IBAN, $i);
        return $ret;
    }

$comment = 'Bla bla';

//Auflistung eurer verschiedenen Posten im Format [Produktbezeichnung, Menge, Einzelpreis]
$invoiceItems = array();
$deliveryNotes = getDeliveryNotes(true, NULL, secGET('id'), true, true);
if(!$deliveryNotes) {
    // No delivery notes found
} else {
    if($deliveryNotes -> num_rows > 0) {
        
        $conn = new Mysql();
        $conn -> dbConnect();
        
        while($row = $deliveryNotes -> fetch_assoc()) {
            // Select price for product
            $conn -> select('T_Pricing', 'price', 'productId = ' . $row['productId'] . ' AND year = ' . $row['year']);
            $price = $conn -> getFirstRow();
            
            $newDate = date("d.m.Y", strtotime($row['deliverDate']));
            $item = array($row['nr'], $newDate, $row['amount'], $price['price']);
            array_push($invoiceItems, $item);
        }
        
        $conn -> dbDisconnect();
        $conn = NULL;
    }
}

//Höhe eurer Umsatzsteuer. 0.19 für 19% Umsatzsteuer
$umsatzsteuer = 0.0; 
        
        $pricePerUnit = '1';

        $invoiceName = $invoice["name"] . '_' . (string)$inv -> invoiceYear . '_' . (string)$inv -> invoiceNr;

$pdfName = $invoiceName;
 
//////////////////////////// Inhalt des PDFs als HTML-Code \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 
 
// Erstellung des HTML-Codes. Dieser HTML-Code definiert das Aussehen eures PDFs.
// tcpdf unterstützt recht viele HTML-Befehle. Die Nutzung von CSS ist allerdings
// stark eingeschränkt.
 
$html = '
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
<tr>
    <td width="60%">' . $invoice["sender_name"] . '<br>'
        . $invoice["sender_address"] . '<br>'
        . $invoice["sender_postalCode"] . ' ' . $invoice["sender_city"] . '</td>
    <td width="25%">
Rechnungsnummer:<br>
Rechnungsdatum:
    </td>
    <td width="15%" style="text-align: right;">'
        . $inv -> invoiceNr . '<br>'
        . $inv -> invoiceDate . '
    </td>
</tr>
<tr>
    <td style="font-size:1.3em; font-weight: bold;">
        <br><br>' . $invoice["name"] . '<br>
    </td>
</tr>
<tr>
    <td colspan="2">' . nl2br(trim($inv -> invoiceReceiver)) . '</td>
</tr>
</table>
<br><br><br>
 
<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">
<tr style="background-color: #4a8a16; padding:5px; color:white;">
    <td style="padding:5px;">
        <b>Lieferschein-Nr</b>
    </td>
    <td style="text-align: center;">
        <b>Lieferdatum</b>
    </td>
    <td style="text-align: center;">
        <b>Menge</b>
    </td>
    <td style="text-align: center;">
        <b>Preis</b>
    </td>
</tr>';

// Add items
$totalAmount = 0;
foreach($invoiceItems as $item) {
    // Calculate price
    $price = $item[3] * $item[2];
    $totalAmount += $price;
    $html .= '
<tr>
    <td style="text-align: center;">' . $item[0].  '</td>
    <td style="text-align: center;">' . $item[1] . '</td>
    <td style="text-align: right;">' . $item[2] . ' ' . $inv -> volumeUnit . '</td>
    <td style="text-align: center;">' . number_format($price, 2, ',', '') . ' Euro</td>
</tr>';
}
$html .="</table>";

$html .= '
<hr>
<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">';
if($umsatzsteuer > 0) {
 $netto = $totalAmount / (1+$umsatzsteuer);
 $umsatzsteuer_betrag = $totalAmount - $netto;
 
 $html .= '
 <tr>
    <td colspan="3">Zwischensumme (Netto)</td>
    <td style="text-align: center;">'.number_format($netto , 2, ',', '').' Euro</td>
 </tr>
 <tr>
    <td colspan="3">Umsatzsteuer ('.intval($umsatzsteuer*100).'%)</td>
    <td style="text-align: center;">'.number_format($umsatzsteuer_betrag, 2, ',', '').' Euro</td>
 </tr>';
}
 
$html .='
<tr>
    <td colspan="3"><b>Gesamtbetrag: </b></td>
    <td style="text-align: center;"><b>'.number_format($totalAmount, 2, ',', '').' Euro</b></td>
</tr> 
</table>
<br><br><br>';

    if(isset($comment)) {
        $html .= $comment;
        $html .= '<br><br><br>';
    }

// Bankverbindung
$html .= "<strong>Bankverbindung</strong>:"
. "<br>" . $invoice["bank"]
. "<br>IBAN: " . formatIBAN($invoice["IBAN"])
. "<br>BIC: " . $invoice["BIC"];
 

    // Generate and show PDF document
    // ------------------------------
    include 'modules/pdfGenerator.php';

    $pdfGen = new pdfGenerator();
    $pdfGen -> createPDF($invoice["author"], $invoiceName, $invoiceName, $html);
    $pdfGen -> showInBrowser($pdfName);
?>
