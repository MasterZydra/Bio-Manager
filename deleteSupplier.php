<?php
/*
* deleteSupplier.php
* ------------------
* This form is used to delete a supplier.
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
<h1>Lieferant löschen</h1>

<p>
    <a href="supplier.php">Alle Lieferanten anzeigen</a>    
</p>

<?php
    $showDialog = true;
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Lieferant übergeben. Zurück zu <a href="supplier.php">Alle Lieferanten anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        $conn -> select('T_Supplier', '*', 'id = ' . $_GET['id']);
        $row = $conn -> getFirstRow();
        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Der ausgewählte Lieferant wurde in der Datenbank nicht gefunden. Zurück zu <a href="supplier.php">Alle Lieferanten anzeigen</a>';
            echo '</div>';
            $showDialog = false;
        } else {
            $conn = new Mysql();
            $conn -> dbConnect();
            if(isset($_GET['delete'])) {
                $conn -> delete('T_Supplier', 'id = ' . $_GET['id']);
                echo '<div class="infobox">';
                echo 'Der Lieferant <strong>' . $row['name'] . '</strong> wurde gelöscht.';
                echo '</div>';
                $showDialog = false;
            }
            $conn -> dbDisconnect();
            $conn = NULL;
        }
    }
    if($showDialog) {
?>
<form action="?id=<?php echo $row['id']; ?>&delete=1" method="post">
    Wollen Sie den Eintrag wirklich löschen?<br>
    <button>Ja</button><button type="button" onclick="window.location.href='supplier.php'">Abbrechen</button>
</form>
<?php
     }
    include 'modules/footer.php';
?>