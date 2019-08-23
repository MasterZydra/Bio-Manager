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
            "type" => "int",
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
        $conn -> dbDisconnect();
        
        echo '<div class="infobox">';
        echo 'Die Rechnung <strong>' . $_POST["invoice_year"] . ' ' . $invoice_number . '</strong> wurde hinzugefügt';
        echo '</div>';
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

