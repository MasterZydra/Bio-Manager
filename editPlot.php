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

        $conn -> select('T_Plot', '*', 'id = ' . $_GET['id']);
        $row = $conn -> getFirstRow();
        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Das ausgewählte Flurstück wurde in der Datenbank nicht gefunden. Zurück zu <a href="plot.php">Alle Flurstücke anzeigen</a>';
            echo '</div>';
        } else {
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post">
    <label>Nummer:<br>
        <input type="text" name="plot_nr" required autofocus value=
           <?php
                if($alreadyExist) {
                    echo '"' . $_POST["plot_nr"] . '"';
                } else {
                    echo '"' . $row['nr'] . '"';
                }
            ?>>
    </label><br>
    <label>Name:<br>
        <input type="text" name="plot_name" required value=
           <?php
                if($alreadyExist) {
                    echo '"' . $_POST["plot_name"] . '"';
                } else {
                    echo '"' . $row['name'] . '"';
                }
            ?>>
    </label><br>
    <label>Gemarkung:<br>
        <input type="text" name="plot_subdistrict" required value=
           <?php
                if($alreadyExist) {
                    echo '"' . $_POST["plot_subdistrict"] . '"';
                } else {
                    echo '"' . $row['subdistrict'] . '"';
                }
            ?>>
    </label><br>
    <label>Lieferant:<br>
        <?php
            if($alreadyExist && $_POST['supplierId']) {
                echo supplierSelectBox(false, $_POST['supplierId'], false);
            } else {
                echo supplierSelectBox(false, $row['supplierId'], false);
            }
         ?>
    </label><br>
    <button>Änderungen speichern</button>
</form>
<?php
        }
    }
    include 'modules/footer.php';
?>