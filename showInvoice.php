<?php
/*
* showInvoice.php
* ----------------
* This page shows an invoice.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/
    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isMaintainer() && !isInspector()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/invoice.php';
    

    $conn = new Mysql();
    $conn -> dbConnect();
    $conn -> select('T_Invoice', 'invoiceDate, year, nr', 'id = ' . $_GET['id']);
    $row = $conn -> getFirstRow();
    $conn -> dbDisconnect();
    $conn = NULL;

    // Got to invoice overview if no invoice was found
    if (is_null($row)) {
        header("Location: invoice.php");
        exit();
    }

    $inv = new invoice();


    $inv -> pdfName             = getSetting('invoiceName');
    $inv -> pdfAuthor           = getSetting('invoiceAuthor');
    $inv -> invoiceYear         = $row['year'];
    $inv -> invoiceNr           = $row['nr'];
    $inv -> invoiceDate         = date("d.m.Y", strtotime($row['invoiceDate']));
    $inv -> invoiceSender       = getSetting('invoiceSender');
    $inv -> invoiceReceiver     = getSetting('invoiceReceiver');
    $inv -> bankDetails_name    = getSetting('invoiceBankName');
    $inv -> bankDetails_IBAN    = getSetting('invoiceIBAN');
    $inv -> bankDetails_BIC     = getSetting('invoiceBIC');


    $volumeUnit = getSetting('volumeUnit');

$comment = 'Bla bla';

//Auflistung eurer verschiedenen Posten im Format [Produktbezeichnung, Menge, Einzelpreis]
$invoiceItems = array();
$deliveryNotes = getDeliveryNotes(true, NULL, $_GET['id'], true, true);
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

$pdfName = $inv -> getInvoiceName() . '.pdf';
 
 
//////////////////////////// Inhalt des PDFs als HTML-Code \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 
 
// Erstellung des HTML-Codes. Dieser HTML-Code definiert das Aussehen eures PDFs.
// tcpdf unterstützt recht viele HTML-Befehle. Die Nutzung von CSS ist allerdings
// stark eingeschränkt.
 
$html = '
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
    <tr>
        <td width="60%">' . nl2br(trim($inv -> invoiceSender)) . '</td>
        <td width="25%">
Rechnungsnummer:<br>
Rechnungsdatum:
         </td>
        <td width="15%" style="text-align: right;">
' . $inv -> invoiceNr . '<br>
' . $inv -> invoiceDate . '
         </td>
     </tr>
     <tr>
        <td style="font-size:1.3em; font-weight: bold;">
            <br><br>
Rechnung
            <br>
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
            <td style="text-align: right;">' . $item[2] . ' ' . $volumeUnit . '</td>
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
/*
if(isset($comment) {
 $html .= $comment;
}*/

// Bankverbindung
$html .= "<strong>Bankverbindung</strong>:"
. "<br>" . $inv -> bankDetails_name
. "<br>IBAN: " . $inv -> bankDetails_IBAN
. "<br>BIC: " . $inv -> bankDetails_BIC;
 
 
 
//////////////////////////// Erzeugung eures PDF Dokuments \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 
// TCPDF Library laden
require_once('ext/TCPDF/tcpdf.php');
 
// Erstellung des PDF Dokuments
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 
// Dokumenteninformationen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($inv -> pdfAuthor);
$pdf->SetTitle($inv -> getInvoiceName());
$pdf->SetSubject($inv -> getInvoiceName());
 
 
// Header und Footer Informationen
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
// Auswahl des Font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
// Auswahl der MArgins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
// Automatisches Autobreak der Seiten
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
// Image Scale 
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
// Schriftart
$pdf->SetFont('dejavusans', '', 10);
 
// Neue Seite
$pdf->AddPage();
 
// Fügt den HTML Code in das PDF Dokument ein
$pdf->writeHTML($html, true, false, true, false, '');
 
//Ausgabe der PDF
 
//Variante 1: PDF direkt an den Benutzer senden:
$pdf->Output($pdfName, 'I');
 
//Variante 2: PDF im Verzeichnis abspeichern:
//$pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
//echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';
 
?>
