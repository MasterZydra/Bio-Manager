<?php
/*
* addDeliveryNote.php
* ---------------
* This form is used to add a new delivery note.
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
<h1>Lieferscheine hinzufügen</h1>

<p>
    <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>
</p>
<?php
    if(isset($_GET['add'])) {
        $conn = new Mysql();
        $conn -> dbConnect();
        
        $NULL = [
            "type" => "null",
            "val" => "null"
        ];
        
        $note_year = [
            "type" => "int",
            "val" => $_POST["note_year"]
        ];
        
        $note_nr = [
            "type" => "int",
            "val" => $_POST["note_number"]
        ];
        
        $note_date = [
            "type" => "char",
            "val" => $_POST["note_date"]
        ];
        
        $note_amount = [
            "type" => "int",
            "val" => $_POST["note_amount"]
        ];
        
        $data = array($NULL, $note_year, $note_nr, $note_date, $note_amount, $NULL);
        
        $conn -> insertInto('T_DeliveryNote', $data);
        $conn -> dbDisconnect();
        
        echo '<div class="infobox">';
        echo 'Der Lieferschein <strong>' . $_POST["note_year"] . ' ' . $_POST["note_number"] . '</strong> wurde hinzugefügt';
        echo '</div>';
    }
?>
<form action="?add=1" method="POST">
    <label>Jahr:<br>
        <input type="number" name="note_year" value="<?php echo date("Y"); ?>" required autofocus>
    </label><br>
    <label>Nummer des Lieferscheins:<br>
        <input type="number" name="note_number" value="" required>
    </label><br>
    <label>Lieferdatum:<br>
        <input type="date" name="note_date" value="<?php echo date('Y-m-d'); ?>">
    </label><br>
    <label>Liefermenge:<br>
        <input type="number" name="note_amount">
    </label><br>
    <label>Lieferant:<br>
        <?php echo supplierSelectBox(false, NULL, false); ?>
    </label><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>
