<?php
/*
* showCropVolumeDistribution.php
* ------------------------------
* Show crop volume distribution per plot.
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
            'T_DeliveryNote RIGHT JOIN T_CropVolumeDistribution ON T_DeliveryNote.id = T_CropVolumeDistribution.deliveryNoteId ' .
            'LEFT JOIN T_Plot ON T_CropVolumeDistribution.plotId = T_Plot.id',
            'T_Plot.nr, T_Plot.name, SUM(T_CropVolumeDistribution.amount) as amount',
            'T_DeliveryNote.year = ' . secPOST('invoiceYear') . ' GROUP BY T_Plot.nr');
        $conn -> dbDisconnect();
        $conn = NULL;
                
        // Process data
        $pdata = array();
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $pdata[$row["nr"]] = array("name" => $row["name"], "amount" => $row["amount"]);
            }
        }
        
        $docName = "Übersicht Mengenverteilung " . secPOST('invoiceYear');
        
        $html = '<table cellpadding="5" cellspacing="0" style="width: 100%; ">
                    <tr><td width="100%">
                        <h1 style="text-align: center;">' . $docName . '</h1><br>
      
                        <table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">
                            <tr style="background-color: #4a8a16; padding:5px; color:white;">
                                <td style="padding:5px;">
                                    <b>Flurstück</b>
                                </td>
                                <td>
                                    <b>Name</b>
                                </td>
                                <td>
                                    <b>Menge in '.getSetting('volumeUnit').'</b>
                                </td>
                            </tr>';

        // Add items
        $totalAmount = 0;
        $keys = array_keys($pdata);
        foreach($keys as $key) {
            $totalAmount += $pdata[$key]["amount"];
            $html .= '
                <tr>
                    <td style="text-align: left;">' . $key . '</td>
                    <td style="text-align: left;">' . $pdata[$key]["name"] . '</td>
                    <td style="text-align: right;">' . number_format($pdata[$key]["amount"], 2, ',', '.') . '</td>
                </tr>';
        }
        $html .= '</table>
                </td></tr></table>';

        $html .= '
        <hr>
        <table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">
            <tr>
                <td colspan="3"><b>Gesamtmenge in '.getSetting('volumeUnit').': </b></td>
                <td style="text-align: right;"><b>'.number_format($totalAmount, 2, ',', '.').'</b></td>
            </tr> 
        </table>';
        
        // Generate and show PDF document
        // ------------------------------
        include 'modules/pdfGenerator.php';

        $pdfGen = new pdfGenerator();
        $pdfGen -> createPDF($invoice["author"], $docName, $docName, $html);
        $pdfGen -> showInBrowser($docName . '_' . date('Y_m_d'));
    } else {
        include 'modules/header.php';
?>
<h1>Mengenverteilung anzeigen</h1>

<form action="?show=1" method="POST" class="requiredLegend">    
    <label for="invoiceYear" class="required">Rechnungsjahr:</label><br>
    <?php echo invoiceYearsSelectBox(NULL, strval(date("Y"))); ?><br>
    
    <button>Anzeigen</button>
</form>
<?php
        include 'modules/footer.php';
    }
?>