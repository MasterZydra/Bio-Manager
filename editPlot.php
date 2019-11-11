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
* 23.09.2019:
*   - Use prepared statements for selecting the data
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

    include_once 'modules/Mysql_preparedStatement_BioManager.php';
?>

<h1>Flurstück bearbeiten</h1>

<p>
    <a href="plot.php">Alle Flurstücke anzeigen</a>
</p>

<?php
    $alreadyExist = false;
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Flurstück übergeben. Zurück zu <a href="plot.php">Alle Flurstücke anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        
        
        $alreadyExist = isset($_POST["plot_nr"]) && alreadyExistsPlot($_POST["plot_nr"], $_GET['id']);
        if(isset($_GET['edit'])) {
            if($alreadyExist) {
                echo '<div class="warning">';
                echo 'Das Flurstück <strong>' . $_POST["plot_nr"] . '</strong> existiert bereits';
                echo '</div>';
            } else {
                $set = 'nr = \'' . $_POST['plot_nr'] . '\', '
                    . 'name = \'' . $_POST['plot_name'] . '\', '
                    . 'subdistrict = \'' . $_POST['plot_subdistrict'] . '\'';
                if(!isset($_POST["supplierId"]) || !$_POST["supplierId"]) {
                    $set .= ', supplierId = NULL';
                } else {
                    $set .= ', supplierId = ' . $_POST["supplierId"];
                }
                $conn -> update(
                    'T_Plot',
                    $set,
                    'id = ' . $_GET['id']);
                echo '<div class="infobox">';
                echo 'Die Änderungen wurden erfolgreich gespeichert';
                echo '</div>';
            }
        }

        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Select data
        $prepStmt = new mysql_preparedStatement_BioManager();
        $row = $prepStmt -> selectWhereId("T_Plot", $_GET['id']);
        $prepStmt -> destroy();
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Das ausgewählte Flurstück wurde in der Datenbank nicht gefunden. Zurück zu <a href="plot.php">Alle Flurstücke anzeigen</a>';
            echo '</div>';
        } else {
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post" class="requiredLegend">
    <label for="plot_nr" class="required">Nummer:</label><br>
    <input id="plot_nr" name="plot_nr" type="text" required autofocus value=
       <?php
            echo ($alreadyExist) ? '"' . $_POST["plot_nr"] . '"' : '"' . $row['nr'] . '"';
        ?>><br>
    
    <label for="plot_name" class="required">Name:</label><br>
    <input id="plot_name" name="plot_name" type="text" required value=
       <?php
            echo ($alreadyExist) ? '"' . $_POST["plot_name"] . '"' : '"' . $row['name'] . '"';
        ?>><br>
    
    <label for="plot_subdistrict" class="required">Gemarkung:</label><br>
    <input id="plot_subdistrict" name="plot_subdistrict" type="text" required value=
       <?php
            echo ($alreadyExist) ? '"' . $_POST["plot_subdistrict"] . '"' : '"' . $row['subdistrict'] . '"';
        ?>><br>
    
    <label for="supplierId">Lieferant:</label><br>
    <?php
        if($alreadyExist && $_POST['supplierId']) {
            echo supplierSelectBox(false, $_POST['supplierId'], false);
        } else {
            echo supplierSelectBox(false, $row['supplierId'], false);
        }
     ?><br>
    
    <button>Änderungen speichern</button>
</form>
<?php
        }
    }
    include 'modules/footer.php';
?>