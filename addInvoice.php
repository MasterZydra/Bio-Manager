<?php
/*
* addInvoice.php
* ---------------
* This form is used to add a new invoice.
*
* @Author: David Hein
*/
include 'System/Autoloader.php';

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (!isMaintainer()) {
    header("Location: invoice.php");
    exit();
}

    include 'Modules/header.php';

    include 'Modules/selectBox_BioManager.php';
?>
<h1>Rechnung hinzufügen</h1>

<p>
    <a href="invoice.php">Alle Rechnungen anzeigen</a>
</p>
<?php
if (isset($_GET['add'])) {
    $deliveryNotes = getDeliveryNotes(true, secPOST("invoice_year"), null, false, true, true);
    if (!$deliveryNotes) {
        echo '<div class="warning">';
        echo 'Es gibt keine offenen Lieferscheine.';
        echo '</div>';
    } else {
        $conn = new \System\Modules\Database\MySQL\MySql();
        $conn -> dbConnect();

        $NULL = [
            "type" => "null",
            "val" => "null"
        ];

        $invoice_year = [
            "type" => "int",
            "val" => secPOST("invoice_year")
        ];

        $invoice_number = getNextInvoiceNr($conn, secPOST("invoice_year"));
        $invoice_nr = [
            "type" => "char",
            "val" => $invoice_number
        ];

        $invoice_Date = [
            "type" => "char",
            "val" => date("Y-m-d")
        ];

        $invoice_Paid = [
            "type" => "char",
            "val" => "0"
        ];

        $recipientId = [
            "type" => "int",
            "val" => secPOST("recipientId")
        ];

        $data = array($NULL, $invoice_year, $invoice_nr, $invoice_Date, $invoice_Paid, $recipientId);
        $conn -> insertInto('T_Invoice', $data);
        // Get id
        $conn -> select(
            'T_Invoice',
            'id, year',
            'year = ' . secPOST("invoice_year") . ' '
            . 'AND nr = ' . $invoice_number
        );
        $row = $conn -> getFirstRow();
        if (!is_null($row)) {
            $conn -> update(
                'T_DeliveryNote',
                'invoiceId = ' . $row['id'],
                'year = ' . $row['year'] . ' '
                . 'AND invoiceId IS NULL '
                . 'AND deliverDate IS NOT NULL '
                . 'AND amount IS NOT NULL '
                . 'AND supplierId IS NOT NULL'
            );
        } else {
            echo '<div class="warning">';
            echo 'Beim Einfügen ist ein Fehler aufgetreten.';
            echo '</div>';
        }


        $conn -> dbDisconnect();

        echo '<div class="infobox">';
        echo 'Die Rechnung <strong>' . secPOST("invoice_year") . ' ' . $invoice_number . '</strong> wurde hinzugefügt';
        echo '</div>';
    }
}
?>
<form action="?add=1" method="POST" class="requiredLegend">
    <label for="invoice_year" class="required">Jahr:</label><br>
    <input id="invoice_year" name="invoice_year" type="number" value="<?php echo date("Y"); ?>" required autofocus><br>
    
    <label for="recipientId" class="required">Abnehmer:</label><br>
    <?php echo recipientSelectBox(); ?><br>
    
    <button>Hinzufügen</button>
</form>
<?php
    include 'Modules/footer.php';
?>

