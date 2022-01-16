<?php
/*
* addDeliveryNote.php
* ---------------
* This form is used to add a new delivery note.
*
* @Author: David Hein
*/

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (!isMaintainer()) {
    header("Location: deliveryNote.php");
    exit();
}

include 'Modules/header.php';

include 'Modules/selectBox_BioManager.php';
?>
<h1>Lieferscheine hinzufügen</h1>

<p>
    <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>
</p>
<?php
if (isset($_GET['add'])) {
    $conn = new \System\Modules\Database\MySQL\MySql();
    $conn -> dbConnect();

    $NULL = [
        "type" => "null",
        "val" => "null"
    ];

    $note_year = [
        "type" => "int",
        "val" => secPOST("note_year")
    ];

    $note_number = getNextDeliveryNoteNr($conn, secPOST("note_year"));
    $note_nr = [
        "type" => "int",
        "val" => $note_number
    ];

    // Deliver Date
    if (!$_POST["note_date"]) {
        $note_date = [
            "type" => "null",
            "val" => "null"
        ];
    } else {
        $note_date = [
            "type" => "char",
            "val" => secPOST("note_date")
        ];
    }

    // Deliver Amount
    if (!$_POST["note_amount"]) {
        $note_amount = [
            "type" => "null",
            "val" => "null"
        ];
    } else {
        $note_amount = [
            "type" => "int",
            "val" => secPOST("note_amount")
        ];
    }

    // ProductId
    $productId = [
        "type" => "int",
        "val" => secPOST("productId")
    ];

    // SupplierId
    if (!isset($_POST["supplierId"]) || !secPOST("supplierId")) {
        $note_supplierId = [
            "type" => "null",
            "val" => "null"
        ];
    } else {
        $note_supplierId = [
            "type" => "char",
            "val" => secPOST("supplierId")
        ];
    }
    $data = array($NULL, $note_year, $note_nr, $note_date, $note_amount, $productId, $note_supplierId, $NULL);

    $conn -> insertInto('T_DeliveryNote', $data);
    $conn -> dbDisconnect();

    echo '<div class="infobox">';
    echo 'Der Lieferschein <strong>' . secPOST("note_year") . ' ' . $note_number . '</strong> wurde hinzugefügt';
    echo '</div>';
}
?>
<form action="?add=1" method="POST" class="requiredLegend">
    <label for="note_year" class="required">Jahr:</label><br>
    <input id="note_year" name="note_year" type="number" value="<?php echo date("Y"); ?>" required autofocus><br>
    
    <label for="productId" class="required">Produkt:</label><br>
    <?php echo productSelectBox(); ?><br>
    
    <label for="note_date" class="required">Lieferdatum:</label><br>
    <input id="note_date" name="note_date" type="date" value="<?php echo date('Y-m-d'); ?>"><br>
    
    <label for="note_amount">Liefermenge (in <?php echo getSetting('volumeUnit'); ?>):</label><br>
    <input id="note_amount" name="note_amount" type="number" placeholder="Liefermenge eingeben"><br>
    
    <label for="supplierId">Lieferant:</label><br>
    <?php echo supplierSelectBox(false, null, false, true); ?><br>
    
    <button>Hinzufügen</button>
</form>
<?php
    include 'Modules/footer.php';
?>
