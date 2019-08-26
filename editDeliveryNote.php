<?php
/*
* editDeliveryNote.php
* ---------------
* This form is used to edit a delivery note.
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
        header("Location: deliveryNote.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/selectBox_BioManager.php';
?>

<h1>Lieferschein bearbeiten</h1>

<p>
    <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>
</p>

<?php
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Lieferschein übergeben. Zurück zu <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        
        if(isset($_GET['edit'])) {
            // Build set part of query
            $set = 'year = ' . $_POST['note_year'] . ', '
                . 'nr = ' . $_POST['note_number'] . ', '
                . 'productId = ' . $_POST['productId'];
            // Deliver date
            if($_POST['note_date']) {
                $set .= ', deliverDate = \'' . $_POST['note_date'] . '\'';
            } else {
                $set .= ', deliverDate = NULL';
            }
            // Deliver amount
            if($_POST['note_amount']) {
                $set .= ', amount = ' . $_POST['note_amount'];
            } else {
                $set .= ', amount = NULL';
            }
            // Supplier
            if(isset($_POST["supplierId"]) && $_POST["supplierId"]) {
                $set .= ', supplierId = ' . $_POST['supplierId'];
            } else {
                $set .= ', supplierId = NULL';
            }
            $conn -> update(
                'T_DeliveryNote',
                $set,
                'id = ' . $_GET['id']);
            echo '<div class="infobox">';
            echo 'Die Änderungen wurden erfolgreich gespeichert';
            echo '</div>';
        }

        $conn -> select('T_DeliveryNote', '*', 'id = ' . $_GET['id']);
        $row = $conn -> getFirstRow();
        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Der ausgewählte Lieferschein wurde in der Datenbank nicht gefunden. Zurück zu <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>';
            echo '</div>';
        }
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post">
    <label>Jahr:<br>
        <input type="number" name="note_year" value="<?php echo $row['year']; ?>" required autofocus>
    </label><br>
    <label>Nummer:<br>
        <input type="number" name="note_number" value="<?php echo $row['nr']; ?>" required>
    </label><br>
    <label>Produkt:<br>
        <?php echo productSelectBox(NULL, $row['productId']); ?>
    </label><br>
    <label>Lieferdatum:<br>
        <input type="date" name="note_date" value="<?php echo $row['deliverDate']; ?>">
    </label><br>
    <label>Liefermenge:<br>
        <input type="number" name="note_amount" value="<?php echo $row['amount']; ?>" placeholder="Menge eingeben">
    </label><br>
    <label>Lieferant:<br>
        <?php echo supplierSelectBox(false, $row['supplierId'], false); ?>
    </label><br>
    <button>Änderungen speichern</button>
</form>
<?php
    }
    include 'modules/footer.php';
?>