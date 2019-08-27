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
    $alreadyExist = isset($_POST["plot_nr"]) && alreadyExistsPlot($_POST["plot_nr"]);
    if(isset($_GET['add'])) {
        if($alreadyExist) {
            echo '<div class="warning">';
            echo 'Das Flurstück <strong>' . $_POST["plot_nr"] . '</strong> existiert bereits';
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
                "val" => $_POST["plot_nr"]
            ];

            $plot_name = [
                "type" => "char",
                "val" => $_POST["plot_name"]
            ];

            $plot_subdistrict = [
                "type" => "char",
                "val" => $_POST["plot_subdistrict"]
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
                    "val" => $_POST["supplierId"]
                ];
            }

            $data = array($NULL, $plot_nr, $plot_name, $plot_subdistrict, $supplierId);

            $conn -> insertInto('T_Plot', $data);
            $conn -> dbDisconnect();

            echo '<div class="infobox">';
            echo 'Das Flurstück <strong>' . $_POST["plot_nr"] . ' ' . $_POST["plot_name"] . '</strong> wurde hinzugefügt';
            echo '</div>';
        }
    }
?>
<form action="?add=1" method="POST">
    <label>Nummer:<br>
        <input type="text" placeholder="Nummer des Flurstücks" name="plot_nr" required autofocus>
    </label><br>
    <label>Name:<br>
        <input type="text" placeholder="Name des Flurstücks" name="plot_name" required>
    </label><br>
    <label>Gemarkung:<br>
        <input type="text" placeholder="Gemarkung" name="plot_subdistrict" required>
    </label><br>
    <label>Lieferant:<br>
        <?php echo supplierSelectBox(false, NULL, false); ?>
    </label><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>

