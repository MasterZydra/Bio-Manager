<?php
/*
* addInvoice.php
* ---------------
* This form is used to add a new invoice.
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
        header("Location: invoice.php");
        exit();
    }

    include 'modules/header.php';
?>
<h1>Rechnung hinzufügen</h1>

<p>
    <a href="invoice.php">Alle Rechnungen anzeigen</a>
</p>
<?php
    if(isset($_GET['add'])) {
        
        $deliveryNotes = getDeliveryNotes(true, $_POST["invoice_year"], NULL, false, true, true);
        if(!$deliveryNotes) {
            echo '<div class="warning">';
            echo 'Es gibt keine offenen Lieferscheine.';
            echo '</div>';
        } else {
            $conn = new Mysql();
            $conn -> dbConnect();

            $NULL = [
                "type" => "null",
                "val" => "null"
            ];

            $invoice_year = [
                "type" => "int",
                "val" => $_POST["invoice_year"]
            ];

            $invoice_number = getNextInvoiceNr($conn, $_POST["invoice_year"]);
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

            $data = array($NULL, $invoice_year, $invoice_nr, $invoice_Date, $invoice_Paid);
            $conn -> insertInto('T_Invoice', $data);
            // Get id
            $conn -> select(
                'T_Invoice',
                'id, year',
                'year = ' . $_POST["invoice_year"] . ' '
                . 'AND nr = ' . $invoice_number);
            $row = $conn -> getFirstRow();
            if(!is_null($row)) {
                $conn -> update(
                    'T_DeliveryNote',
                    'invoiceId = ' . $row['id'], 'year = ' . $row['year'] . ' '
                    . 'AND invoiceId IS NULL '
                    . 'AND deliverDate IS NOT NULL '
                    . 'AND amount IS NOT NULL '
                    . 'AND supplierId IS NOT NULL');
            } else {
                echo '<div class="warning">';
                echo 'Beim Einfügen ist ein Fehler aufgetreten.';
                echo '</div>';
            }
            
            
            $conn -> dbDisconnect();

            echo '<div class="infobox">';
            echo 'Die Rechnung <strong>' . $_POST["invoice_year"] . ' ' . $invoice_number . '</strong> wurde hinzugefügt';
            echo '</div>';
        }
    }
?>
<form action="?add=1" method="POST">
    <label>Jahr:<br>
        <input type="number" name="invoice_year" value="<?php echo date("Y"); ?>" required autofocus>
    </label><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>

