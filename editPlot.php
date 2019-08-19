<?php
/*
* editPlot.php
* ---------------
* This form is used to edit a plot.
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
        header("Location: plot.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/selectBox_BioManager.php';
?>

<h1>Flurstück bearbeiten</h1>

<p>
    <a href="plot.php">Alle Flurstücke anzeigen</a>
</p>

<?php
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Flurstück übergeben. Zurück zu <a href="plot.php">Alle Flurstücke anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        
        if(isset($_GET['edit'])) {
           $conn -> update(
               'T_Plot',
               'nr = \'' . $_POST['plot_nr'] . '\', '
               . 'name = \'' . $_POST['plot_name'] . '\', '
               . 'subdistrict = \'' . $_POST['plot_subdistrict'] . '\', '
               . 'supplierId = ' . $_POST["supplierId"],
               'id = ' . $_GET['id']);
            echo '<div class="infobox">';
            echo 'Die Änderungen wurden erfolgreich gespeichert';
            echo '</div>';
        }

        $conn -> select('T_Plot', '*', 'id = ' . $_GET['id']);
        $row = $conn -> getFirstRow();
        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Das ausgewählte Flurstück wurde in der Datenbank nicht gefunden. Zurück zu <a href="plot.php">Alle Flurstücke anzeigen</a>';
            echo '</div>';
        }
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post">
    <label>Nummer:<br>
        <input type="text" name="plot_nr" value="<?php echo $row['nr']; ?>" required autofocus>
    </label><br>
    <label>Name:<br>
        <input type="text" name="plot_name" value="<?php echo $row['name']; ?>" required>
    </label><br>
    <label>Gemarkung:<br>
        <input type="text" name="plot_subdistrict" value="<?php echo $row['subdistrict']; ?>" required>
    </label><br>
    <label>Lieferant:<br>
        <?php echo supplierSelectBox(true, $row['supplierId']); ?>
    </label><br>
    <button>Änderungen speichern</button>
</form>
<?php
    }
    include 'modules/footer.php';
?>