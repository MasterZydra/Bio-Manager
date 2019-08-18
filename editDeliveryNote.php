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
           $conn -> update(
                'T_DeliveryNote',
                'year = ' . $_POST['note_year'] . ', '
                . 'nr = ' . $_POST['note_number'] . ', '
                . 'deliverDate = \'' . $_POST['note_date'] . '\', '
                . 'amount = ' . $_POST['note_amount'],
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
    <label>Lieferdatum:<br>
        <input type="date" name="note_date" value="<?php echo $row['deliverDate']; ?>" required>
    </label><br>
    <label>Liefermenge:<br>
        <input type="number" name="note_amount" value="<?php echo $row['amount']; ?>" required>
    </label><br>
    <button>Änderungen speichern</button>
</form>
<?php
    }
    include 'modules/footer.php';
?>