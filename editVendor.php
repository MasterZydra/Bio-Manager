<?php
    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';
    
    // Check permission
    if(!isAllowedToEditVendor()) {
        header("Location: vendor.php");
        exit();
    }

    include 'modules/header.php';
?>

<h1>Lieferant bearbeiten</h1>

<p>
    <a href="vendor.php">Alle Lieferanten anzeigen</a>    
</p>

<?php
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Lieferant übergeben. Zurück zu <a href="vendor.php">Alle Lieferanten anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        
        if(isset($_GET['edit'])) {
            $conn -> selectFreeRun(
                'UPDATE T_Vendor '
                . 'SET name=\'' . $_POST['vendorName'] .'\' '
                . 'WHERE id=' . $_POST['vendorId']);
            echo '<div class="infobox">';
            echo 'Die Änderungen wurden erfolgreich gespeichert';
            echo '</div>';
        }

        $result = $conn -> selectWhere('T_Vendor', 'id', '=', $_GET['id'], 'int');
        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Check if id is valid 
        if ($result->num_rows == 0) {
            echo '<div class="warning">';
            echo 'Der ausgewählte Lieferant wurde in der Datenbank nicht gefunden. Zurück zu <a href="vendor.php">Alle Lieferanten anzeigen</a>';
            echo '</div>';
        } else {
            $row = $result->fetch_assoc();
        }
    }
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post">
    <label>Lieferanten-Nr:
        <input type="text" name="vendorId" value="<?php echo $row['id']; ?>" readonly>
    </label><br>
    <label>Name:
        <input type="text" name="vendorName" value="<?php echo $row['name']; ?>">
    </label><br>
    <button>Änderungen speichern</button>
</form>
<?php
    include 'modules/footer.php';
?>