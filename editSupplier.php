<?php
/*
* editSupplier.php
* ---------------
* This form is used to edit a supplier.
*
* @Author: David Hein
*/
    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';
    
    // Check permission
    if(!isMaintainer() ||
       // Check if id is numeric
       (isset($_GET['id']) && !is_numeric($_GET['id'])))
    {
        header("Location: supplier.php");
        exit();
    }

    include 'modules/header.php';

    include_once 'modules/Mysql_preparedStatement_BioManager.php';
?>

<h1>Lieferant bearbeiten</h1>

<p>
    <a href="supplier.php">Alle Lieferanten anzeigen</a>    
</p>

<?php
    $alreadyExist = false;
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Lieferant übergeben. Zurück zu <a href="supplier.php">Alle Lieferanten anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        
        $alreadyExist = isset($_POST["supplierName"]) && alreadyExistsSupplier(secPOST("supplierName"), secGET('id'));
        if(isset($_GET['edit'])) {
            if($alreadyExist) {
                echo '<div class="warning">';
                echo 'Der Lieferant <strong>' . secPOST("supplierName") . '</strong> existiert bereits';
                echo '</div>';
            } else {
                updateSupplier($conn, secGET('id'), secPOST("supplierName"), secPOST('supplierInactive'));
                echo '<div class="infobox">';
                echo 'Die Änderungen wurden erfolgreich gespeichert';
                echo '</div>';
            }
        }
        
        $conn -> dbDisconnect();
        $conn = NULL;

        // Select data
        $prepStmt = new mysql_preparedStatement_BioManager();
        $row = $prepStmt -> selectWhereId("T_Supplier", secGET('id'));
        $prepStmt -> destroy();
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Der ausgewählte Lieferant wurde in der Datenbank nicht gefunden. Zurück zu <a href="supplier.php">Alle Lieferanten anzeigen</a>';
            echo '</div>';
        } else {
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post" class="requiredLegend">
    <label for="supplierName" class="required">Name:</label><br>
    <input id="supplierName" name="supplierName" type="text" required autofocus value=
        <?php
            echo ($alreadyExist) ? '"' . secPOST("supplierName") . '"' : '"' . $row['name'] . '"';
        ?>><br>
    
    <label>
        <input type="hidden" name="supplierInactive" value="0">
        <input type="checkbox" name="supplierInactive" value="1"
           <?php
                if((!$alreadyExist && $row['inactive']) || ($alreadyExist && $_POST['supplierInactive'])) {
                    echo 'checked';
                }
           ?>>
        Inaktiv
    </label><br>
    <button>Änderungen speichern</button>
</form>
<?php
        }
    }
    include 'modules/footer.php';
?>