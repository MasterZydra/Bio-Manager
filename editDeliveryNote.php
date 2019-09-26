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
* 23.09.2019:
*   - Use prepared statements for selecting the data
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

    include_once 'modules/Mysql_preparedStatement_BioManager.php';
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
            $set = 'productId = ' . $_POST['productId'];
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

        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Select data
        $prepStmt = new mysql_preparedStatement_BioManager();
        $row = $prepStmt -> selectWhereId("T_DeliveryNote", $_GET['id']);
        $prepStmt -> destroy();
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Der ausgewählte Lieferschein wurde in der Datenbank nicht gefunden. Zurück zu <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>';
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
    <?php echo productSelectBox(NULL, $row['productId']); ?><br>
    
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
    include 'modules/footer.php';
?>