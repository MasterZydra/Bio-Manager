<?php
/*
* showSupplierPayments.php
* ----------------------
* Show supplier payments for a given year.
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

    include 'modules/selectBox_BioManager.php';

    if(isset($_GET['show'])) {
        // Check if file exists to prevent warnings
        if (file_exists('config/InvoiceDataConfig.php'))
            include 'config/InvoiceDataConfig.php';
        
        // Collect data
        $conn = new Mysql();
        $conn -> dbConnect();
        $result = $conn -> select(
            'T_DeliveryNote LEFT JOIN T_Supplier ON T_DeliveryNote.supplierId = T_Supplier.id ' .
            'LEFT JOIN T_Product ON T_DeliveryNote.productId = T_Product.id ' .
            'LEFT JOIN T_Pricing ON T_Product.id = T_Pricing.productId',
            'nr, deliverDate, amount, pricePayOut, T_Supplier.id, T_Supplier.name',
            'T_Pricing.year = ' . secPOST('invoiceYear') . ' AND T_DeliveryNote.year = ' . secPOST('invoiceYear'));
        $conn -> dbDisconnect();
        $conn = NULL;
                
        // Process data
        $pdata = array();
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                // Ignore deliveries without supplier
                if (is_null($id))
                    continue;
                // Add new supplier to array
                if(!array_key_exists($id, $pdata)) {
                    $pdata[$id] = array(
                        "name" => $row["name"],
                        "sumAmount" => 0,
                        "sumPrice" => 0.0,
                        "deliveries" => array());
                }
                // Add delivery
                array_push($pdata[$id]["deliveries"],
                           array(
                               "nr" => $row["nr"],
                               "amount" => $row["amount"],
                               "deliverDate" => $row["deliverDate"],
                               "price" => $row["pricePayOut"]));
                // Increase sums
                $pdata[$id]["sumAmount"] += $row["amount"];
                $pdata[$id]["sumPrice"] += $row["pricePayOut"] * $row["amount"];
            }
        }
        
        $docName = "Übersicht Auszahlung " . secPOST('invoiceYear');
        
        $html = '<table cellpadding="5" cellspacing="0" style="width: 100%; ">
                    <tr><td width="100%">
                        <h1 style="text-align: center;">' . $docName . '</h1><br>';
        
        $keys = array_keys($pdata);
        foreach($keys as $key) {
            // Heading
            $html .= '
                <i>' . $pdata[$key]["name"] .'</i><br>
                <table>
                <tr>
                    <th style="text-align: center;"><strong>Lieferschein-Nr.</strong></th>
                    <th style="text-align: center;"><strong>Lieferdatum</strong></th>
                    <th style="text-align: center;"><strong>Menge in ' . getSetting('volumeUnit') . '</strong></th>
                    <th style="text-align: center;"><strong>x Preis</strong></th>
                </tr>';

            // The deliveries
            foreach($pdata[$key]["deliveries"] as $delivery) {
                $html .= '
                    <tr>
                        <td style="text-align: right;">' . $delivery["nr"] . '</td>
                        <td style="text-align: center;">' . date("d.m.Y", strtotime($delivery["deliverDate"])) . '</td>
                        <td style="text-align: right;">' . $delivery["amount"] . '</td>
                        <td style="text-align: right;">x ' . $delivery["price"] . ' = ' .
                            number_format($delivery["price"] * $delivery["amount"], 2, ',', '.') . ' €</td>
                    </tr>';
            }
            
            // Sums
            $html .= '
            <tr style="height:2px;"><td style="height:2px;" colspan="4"><hr></td></tr>
            <tr>
                <td></td>
                <td style="text-align: right;">Summe:</td>
                <td style="text-align: right;">' . $pdata[$key]["sumAmount"] . '</td>
                <td style="text-align: right;">' . number_format($pdata[$key]["sumPrice"], 2, ',', '.') . ' €</td>
            </tr>
            </table><br><br>';
        }
                
        $html .= '</td></tr></table>';
        
        // Generate and show PDF document
        // ------------------------------
        include 'modules/pdfGenerator.php';

        $pdfGen = new pdfGenerator();
        $pdfGen -> createPDF($invoice["author"], $docName, $docName, $html);
        $pdfGen -> showInBrowser($docName . '_' . date('Y_m_d'));
    } else {
        include 'modules/header.php';
?>
<h1>Auszahlungen anzeigen</h1>

<form action="?show=1" method="POST" class="requiredLegend">    
    <label for="invoiceYear" class="required">Rechnungsjahr:</label><br>
    <?php echo invoiceYearsSelectBox(NULL, strval(date("Y"))); ?><br>
    
    <button>Anzeigen</button>
</form>
<?php
        include 'modules/footer.php';
    }
?>