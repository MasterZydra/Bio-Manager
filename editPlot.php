<?php
/*
* editPlot.php
* ---------------
* This form is used to edit a plot.
*
* @Author: David Hein
*/

include 'modules/header_user.php';
include 'modules/PermissionCheck.php';

// Check permission
if (
    !isMaintainer() ||
        // Check if id is numeric
        (isset($_GET['id']) && !is_numeric($_GET['id']))
) {
    header("Location: plot.php");
    exit();
}

include 'modules/header.php';

include 'modules/selectBox_BioManager.php';

include_once 'modules/MySqlPreparedStatementBioManager.php';
?>

<h1>Flurstück bearbeiten</h1>

<p>
    <a href="plot.php">Alle Flurstücke anzeigen</a>
</p>

<?php
    $alreadyExist = false;
if (!isset($_GET['id'])) {
    echo '<div class="warning">';
    echo 'Es wurde kein Flurstück übergeben. Zurück zu <a href="plot.php">Alle Flurstücke anzeigen</a>';
    echo '</div>';
} else {
    $conn = new Mysql();
    $conn -> dbConnect();


    $alreadyExist = isset($_POST["plot_nr"]) && alreadyExistsPlot(secPOST("plot_nr"), secGET('id'));
    if (isset($_GET['edit'])) {
        if ($alreadyExist) {
            echo '<div class="warning">';
            echo 'Das Flurstück <strong>' . secPOST("plot_nr") . '</strong> existiert bereits';
            echo '</div>';
        } else {
            $set = 'nr = \'' . secPOST("plot_nr") . '\', '
                . 'name = \'' . secPOST("plot_name") . '\', '
                . 'subdistrict = \'' . secPOST('plot_subdistrict') . '\'';
            if (!isset($_POST["supplierId"]) || !$_POST["supplierId"]) {
                $set .= ', supplierId = NULL';
            } else {
                $set .= ', supplierId = ' . secPOST("supplierId");
            }
            $conn -> update(
                'T_Plot',
                $set,
                'id = ' . secGET('id')
            );
            echo '<div class="infobox">';
            echo 'Die Änderungen wurden erfolgreich gespeichert';
            echo '</div>';
        }
    }

    $conn -> dbDisconnect();
    $conn = null;

    // Select data
    $prepStmt = new MySqlPreparedStatementBioManager();
    $row = $prepStmt -> selectWhereId("T_Plot", secGET('id'));
    $prepStmt -> destroy();

    // Check if id is valid
    if ($row == null) {
        echo '<div class="warning">';
        echo 'Das ausgewählte Flurstück wurde in der Datenbank nicht gefunden.';
        echo 'Zurück zu <a href="plot.php">Alle Flurstücke anzeigen</a>';
        echo '</div>';
    } else {
        ?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post" class="requiredLegend">
    <label for="plot_nr" class="required">Nummer:</label><br>
    <input id="plot_nr" name="plot_nr" type="text" required autofocus value=
        <?php
            echo ($alreadyExist) ? '"' . secPOST("plot_nr") . '"' : '"' . $row['nr'] . '"';
        ?>><br>
    
    <label for="plot_name" class="required">Name:</label><br>
    <input id="plot_name" name="plot_name" type="text" required value=
        <?php
        echo ($alreadyExist) ? '"' . secPOST("plot_name") . '"' : '"' . $row['name'] . '"';
        ?>><br>
    
    <label for="plot_subdistrict" class="required">Gemarkung:</label><br>
    <input id="plot_subdistrict" name="plot_subdistrict" type="text" required value=
        <?php
        echo ($alreadyExist) ? '"' . secPOST('plot_subdistrict') . '"' : '"' . $row['subdistrict'] . '"';
        ?>><br>
    
    <label for="supplierId">Lieferant:</label><br>
        <?php
        if ($alreadyExist && $_POST['supplierId']) {
            echo supplierSelectBox(false, secPOST("supplierId"), false);
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