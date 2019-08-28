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

        $conn -> select('T_Pricing', '*', 'id = ' . $_GET['id']);
        $row = $conn -> getFirstRow();
        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Der ausgewählte Lieferschein wurde in der Datenbank nicht gefunden. Zurück zu <a href="pricing.php">Alle Preise anzeigen</a>';
            echo '</div>';
        }
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post">
    <label>Jahr:<br>
        <input type="number" name="price_year" required autofocus value=
           <?php
                if($alreadyExist) {
                    echo '"' . $_POST["price_year"] . '"';
                } else {
                    echo '"' . $row['year'] . '"';
                }
            ?>>
    </label><br>
    <label>Produkt:<br>
        <?php
            if($alreadyExist && $_POST['productId']) {
                echo productSelectBox(NULL, $_POST['productId']);
            } else {
                echo productSelectBox(NULL, $row['productId']);
            }
        ?>
    </label><br>
    <label>Preis (pro <?php echo getSetting('volumeUnit'); ?>):<br>
        <input type="number" step="0.01" name="price" placeholder="Preis eingeben" required value=
           <?php
                if($alreadyExist) {
                    echo '"' . $_POST["price"] . '"';
                } else {
                    echo '"' . $row['price'] . '"';
                }
            ?>>
    </label><br>
    <label>Auszahlung an Lieferanten (pro <?php echo getSetting('volumeUnit'); ?>):<br>
        <input type="number" step="0.01" name="price_payOut" placeholder="Preis eingeben" required value=
           <?php
                if($alreadyExist) {
                    echo '"' . $_POST["price_payOut"] . '"';
                } else {
                    echo '"' . $row['pricePayOut'] . '"';
                }
            ?>>
    </label><br>
    <button>Änderungen speichern</button>
</form>
<?php
    }
    include 'modules/footer.php';
?>