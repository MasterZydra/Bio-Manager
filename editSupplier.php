<?php
/*
* editSupplier.php
* ---------------
* This form is used to edit a supplier.
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
        header("Location: supplier.php");
        exit();
    }

    include 'modules/header.php';
?>

<h1>Lieferant bearbeiten</h1>

<p>
    <a href="supplier.php">Alle Lieferanten anzeigen</a>    
</p>

<?php
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Lieferant übergeben. Zurück zu <a href="supplier.php">Alle Lieferanten anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        
        if(isset($_GET['edit'])) {
            $conn -> update(
                'T_Supplier',
                'name = \'' . $_POST['supplierName'] .'\'',
                'id = ' . $_GET['id']);
            echo '<div class="infobox">';
            echo 'Die Änderungen wurden erfolgreich gespeichert';
            echo '</div>';
        }

        $conn -> select('T_Supplier', '*', 'id = ' . $_GET['id']);
        $row = $conn -> getFirstRow();
        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Der ausgewählte Lieferant wurde in der Datenbank nicht gefunden. Zurück zu <a href="supplier.php">Alle Lieferanten anzeigen</a>';
            echo '</div>';
        }
    }
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post">
    <label>Lieferanten-Nr:<br>
        <input type="text" name="supplierId" value="<?php echo $row['id']; ?>" readonly>
    </label><br>
    <label>Name:<br>
        <input type="text" name="supplierName" value="<?php echo $row['name']; ?>">
    </label><br>
    <button>Änderungen speichern</button>
</form>
<?php
    include 'modules/footer.php';
?>