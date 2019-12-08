<?php
/*
* addPlot.php
* ---------------
* This form is used to add a new plot.
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
<h1>Flurstück hinzufügen</h1>

<p>
    <a href="plot.php">Alle Flurstücke anzeigen</a>
</p>
<?php
    $alreadyExist = isset($_POST["plot_nr"]) && alreadyExistsPlot(secPOST("plot_nr"));
    if(isset($_GET['add'])) {
        if($alreadyExist) {
            echo '<div class="warning">';
            echo 'Das Flurstück <strong>' . secPOST("plot_nr") . '</strong> existiert bereits';
            echo '</div>';
        } else {
            $conn = new Mysql();
            $conn -> dbConnect();

            $NULL = [
                "type" => "null",
                "val" => "null"
            ];

            $plot_nr = [
                "type" => "char",
                "val" => secPOST("plot_nr")
            ];

            $plot_name = [
                "type" => "char",
                "val" => secPOST("plot_name")
            ];

            $plot_subdistrict = [
                "type" => "char",
                "val" => secPOST("plot_subdistrict")
            ];

            // SupplierId
            if(!isset($_POST["supplierId"]) || !$_POST["supplierId"]) {
                $supplierId = [
                    "type" => "null",
                    "val" => "null"
                ];
            } else {
                $supplierId = [
                    "type" => "int",
                    "val" => secPOST("supplierId")
                ];
            }

            $data = array($NULL, $plot_nr, $plot_name, $plot_subdistrict, $supplierId);

            $conn -> insertInto('T_Plot', $data);
            $conn -> dbDisconnect();

            echo '<div class="infobox">';
            echo 'Das Flurstück <strong>' . secPOST("plot_nr") . ' ' . secPOST("plot_name") . '</strong> wurde hinzugefügt';
            echo '</div>';
        }
    }
?>
<form action="?add=1" method="POST" class="requiredLegend">
    <label for="plot_nr" class="required">Nummer:</label><br>
    <input id="plot_nr" name="plot_nr" type="text" placeholder="Nummer des Flurstücks" required autofocus
        <?php if($alreadyExist) { echo ' value="' . secPOST("plot_nr") . '"'; } ?>><br>
    
    <label for="plot_name" class="required">Name:</label><br>
    <input id="plot_name" name="plot_name" type="text" placeholder="Name des Flurstücks" required
        <?php if($alreadyExist) { echo ' value="' . secPOST("plot_name") . '"'; } ?>><br>
    
    <label for="plot_subdistrict" class="required">Gemarkung:</label><br>
    <input id="plot_subdistrict" name="plot_subdistrict" type="text" placeholder="Gemarkung" required
        <?php if($alreadyExist) { echo ' value="' . secPOST("plot_subdistrict") . '"'; } ?>><br>
    
    <label for="supplierId">Lieferant:</label><br>
    <?php
        if($alreadyExist) {
            echo supplierSelectBox(false, secPOST("supplierId"), false);
        } else {
            echo supplierSelectBox(false, NULL, false);
        }
    ?><br>
    
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>

