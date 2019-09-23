<?php
/*
* editPricing.php
* ---------------
* This form is used to edit a price.
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
        header("Location: deliveryNote.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/selectBox_BioManager.php';

    include 'modules/Mysql_preparedStatement_BioManager.php';
?>

<h1>Preis bearbeiten</h1>

<p>
    <a href="pricing.php">Alle Preise anzeigen</a>
</p>

<?php
    $alreadyExist = false;
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Preis übergeben. Zurück zu <a href="pricing.php">Alle Preise anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        
        $alreadyExist = isset($_POST["productId"]) && isset($_POST["price_year"]) &&
            alreadyExistsPricing($_POST["productId"], $_POST["price_year"], $_GET['id']);
        if(isset($_GET['edit'])) {
            if($alreadyExist) {
                echo '<div class="warning">';
                echo 'Der Preis existiert bereits';
                echo '</div>';
            } else {
                $conn -> update(
                    'T_Pricing',
                    'year = ' . $_POST['price_year'] . ', '
                    . 'productId = ' . $_POST['productId'] . ' ,'
                    . 'price = ' . $_POST['price'] . ', '
                    . 'pricePayOut = ' . $_POST['price_payOut'],
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
        $row = $prepStmt -> selectWhereId("T_Pricing", intval($_GET['id']));
        $prepStmt -> destroy();
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Der ausgewählte Lieferschein wurde in der Datenbank nicht gefunden. Zurück zu <a href="pricing.php">Alle Preise anzeigen</a>';
            echo '</div>';
        } else {
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post" class="requiredLegend">
    <label for="price_year" class="required">Jahr:</label><br>
    <input id="price_year" name="price_year" type="number" required autofocus value=
       <?php
            if($alreadyExist) {
                echo '"' . $_POST["price_year"] . '"';
            } else {
                echo '"' . $row['year'] . '"';
            }
        ?>><br>
    
    <label for="productId" class="required">Produkt:</label><br>
    <?php
        if($alreadyExist && $_POST['productId']) {
            echo productSelectBox(NULL, $_POST['productId']);
        } else {
            echo productSelectBox(NULL, $row['productId']);
        }
    ?><br>
    
    <label for="price" class="required">Preis (pro <?php echo getSetting('volumeUnit'); ?>):</label><br>
    <input id="price" name="price" type="number" step="0.01" placeholder="Preis eingeben" required value=
       <?php
            if($alreadyExist) {
                echo '"' . $_POST["price"] . '"';
            } else {
                echo '"' . $row['price'] . '"';
            }
        ?>><br>
    
    <label for="price_payOut" class="required">Auszahlung an Lieferanten (pro <?php echo getSetting('volumeUnit'); ?>):</label><br>
    <input id="price_payOut" name="price_payOut" type="number" step="0.01" placeholder="Preis eingeben" required value=
       <?php
            if($alreadyExist) {
                echo '"' . $_POST["price_payOut"] . '"';
            } else {
                echo '"' . $row['pricePayOut'] . '"';
            }
        ?>><br>
    
    <button>Änderungen speichern</button>
</form>
<?php
        }
    }
    include 'modules/footer.php';
?>