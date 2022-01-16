<?php
/*
* editDeliveryNote.php
* ---------------
* This form is used to edit a delivery note.
*
* @Author: David Hein
*/

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (
    !isMaintainer() ||
        // Check if id is numeric
        (isset($_GET['id']) && !is_numeric($_GET['id']))
) {
    header("Location: deliveryNote.php");
    exit();
}

include 'Modules/header.php';

include 'Modules/selectBox_BioManager.php';

include_once 'Modules/MySqlPreparedStatementBioManager.php';
?>

<h1>Lieferschein bearbeiten</h1>

<p>
    <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>
</p>

<?php
if (!isset($_GET['id'])) {
    echo '<div class="warning">';
    echo 'Es wurde kein Lieferschein übergeben. Zurück zu <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>';
    echo '</div>';
} else {
    $conn = new \System\Modules\Database\MySQL\MySql();
    $conn -> dbConnect();

    if (isset($_GET['edit'])) {
        // Build set part of query
        $set = 'productId = ' . secPOST('productId');
        // Deliver date
        if ($_POST['note_date']) {
            $set .= ', deliverDate = \'' . secPOST('note_date') . '\'';
        } else {
            $set .= ', deliverDate = NULL';
        }
        // Deliver amount
        if ($_POST['note_amount']) {
            $set .= ', amount = ' . secPOST('note_amount');
        } else {
            $set .= ', amount = NULL';
        }
        // Supplier
        if (isset($_POST["supplierId"]) && $_POST["supplierId"]) {
            $set .= ', supplierId = ' . secPOST('supplierId');
        } else {
            $set .= ', supplierId = NULL';
        }
        $conn -> update(
            'T_DeliveryNote',
            $set,
            'id = ' . secGET('id')
        );
        echo '<div class="infobox">';
        echo 'Die Änderungen wurden erfolgreich gespeichert';
        echo '</div>';
    }

    $conn -> dbDisconnect();
    $conn = null;

    // Select data
    $prepStmt = new MySqlPreparedStatementBioManager();
    $row = $prepStmt -> selectWhereId("T_DeliveryNote", secGET('id'));
    $prepStmt -> destroy();

    // Check if id is valid
    if ($row == null) {
        echo '<div class="warning">';
        echo 'Der ausgewählte Lieferschein wurde in der Datenbank nicht gefunden.';
        echo 'Zurück zu <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>';
        echo '</div>';
    } else {
        ?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post" class="requiredLegend">
    <label>Jahr:<br>
        <input type="number" value="<?php echo $row['year']; ?>" readonly>
    </label><br>
    <label>Nummer:<br>
        <input type="number" value="<?php echo $row['nr']; ?>" readonly>
    </label><br>
    
    <label for="productId" class="required">Produkt:</label><br>
        <?php echo productSelectBox(null, $row['productId']); ?><br>
    
    <label for="note_date" class="required">Lieferdatum:</label><br>
    <input id="note_date" name="note_date" type="date" value="<?php echo $row['deliverDate']; ?>" autofocus><br>
    
    <label>Liefermenge (in <?php echo getSetting('volumeUnit'); ?>):<br>
        <input type="number" name="note_amount" value="<?php echo $row['amount']; ?>" placeholder="Menge eingeben">
    </label><br>
    
    <label>Lieferant:<br>
        <?php echo supplierSelectBox(false, $row['supplierId'], false); ?>
    </label><br>

    <button>Änderungen speichern</button>
</form>
        <?php
    }
}
    include 'Modules/footer.php';
?>