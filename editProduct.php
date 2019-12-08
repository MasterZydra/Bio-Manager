<?php
/*
* editProduct.php
* ---------------
* This form is used to edit a product.
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
        header("Location: product.php");
        exit();
    }

    include 'modules/header.php';

    include_once 'modules/Mysql_preparedStatement_BioManager.php';
?>

<h1>Produkt bearbeiten</h1>

<p>
    <a href="product.php">Alle Produkte anzeigen</a>    
</p>

<?php
    $alreadyExist = false;
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Produkt übergeben. Zurück zu <a href="product.php">Alle Produkte anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        $alreadyExist = isset($_POST["product_name"]) && alreadyExistsProduct($_POST["product_name"]);
        if(isset($_GET['edit'])) {
            if($alreadyExist) {
                echo '<div class="warning">';
                echo 'Das Produkt <strong>' . $_POST["product_name"] . '</strong> existiert bereits';
                echo '</div>';
            } else {
                $conn -> update(
                    'T_Product',
                    'name = \'' . $_POST['product_name'] . '\'',
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
        $row = $prepStmt -> selectWhereId("T_Product", $_GET['id']);
        $prepStmt -> destroy();
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Das ausgewählte Produkt wurde in der Datenbank nicht gefunden. Zurück zu <a href="product.php">Alle Produkte anzeigen</a>';
            echo '</div>';
        } else {
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post" class="requiredLegend">
    <label for="product_name" class="required">Name:</label><br>
    <input id="product_name" name="product_name" type="text" <?php echo $row['name']; ?> required autofocus value=
        <?php
            echo ($alreadyExist) ? '"' . $_POST["product_name"] . '"' : '"' . $row['name'] . '"';
        ?>><br>
    
    <button>Änderungen speichern</button>
</form>
<?php
        }
    }
    include 'modules/footer.php';
?>