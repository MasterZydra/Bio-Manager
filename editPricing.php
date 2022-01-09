<?php
/*
* editPricing.php
* ---------------
* This form is used to edit a price.
*
* @Author: David Hein
*/

include 'modules/header_user.php';
include 'modules/permissionCheck.php';

// Check permission
if (
    !isMaintainer() ||
        // Check if id is numeric
        (isset($_GET['id']) && !is_numeric($_GET['id']))
) {
    header("Location: deliveryNote.php");
    exit();
}

include 'modules/header.php';

include 'modules/selectBox_BioManager.php';

include_once 'modules/MySqlPreparedStatementBioManager.php';
?>

<h1>Preis bearbeiten</h1>

<p>
    <a href="pricing.php">Alle Preise anzeigen</a>
</p>

<?php
    $alreadyExist = false;
if (!isset($_GET['id'])) {
    echo '<div class="warning">';
    echo 'Es wurde kein Preis übergeben. Zurück zu <a href="pricing.php">Alle Preise anzeigen</a>';
    echo '</div>';
} else {
    $conn = new Mysql();
    $conn -> dbConnect();

    $alreadyExist = isset($_POST["productId"]) && isset($_POST["price_year"]) &&
        alreadyExistsPricing(secPOST("productId"), secPOST("price_year"), secGET('id'));
    if (isset($_GET['edit'])) {
        if ($alreadyExist) {
            echo '<div class="warning">';
            echo 'Der Preis existiert bereits';
            echo '</div>';
        } else {
            $conn -> update(
                'T_Pricing',
                'year = ' . secPOST('price_year') . ', '
                . 'productId = ' . secPOST('productId') . ' ,'
                . 'price = ' . secPOST('price') . ', '
                . 'pricePayOut = ' . secPOST('price_payOut'),
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
    $row = $prepStmt -> selectWhereId("T_Pricing", secGET('id'));
    $prepStmt -> destroy();

    // Check if id is valid
    if ($row == null) {
        echo '<div class="warning">';
        echo 'Der ausgewählte Lieferschein wurde in der Datenbank nicht gefunden.';
        echo 'Zurück zu <a href="pricing.php">Alle Preise anzeigen</a>';
        echo '</div>';
    } else {
        ?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post" class="requiredLegend">
    <label for="price_year" class="required">Jahr:</label><br>
    <input id="price_year" name="price_year" type="number" required autofocus value=
        <?php
        if ($alreadyExist) {
            echo "'" . secPOST("price_year") . "'";
        } else {
            echo "'$row[year]'";
        }
        ?>><br>
    
    <label for="productId" class="required">Produkt:</label><br>
        <?php
        if ($alreadyExist && $_POST['productId']) {
            echo productSelectBox(null, secPOST('productId'));
        } else {
            echo productSelectBox(null, $row['productId']);
        }
        ?><br>
    
    <label for="price" class="required">Preis (pro <?php echo getSetting('volumeUnit'); ?>):</label><br>
    <input id="price" name="price" type="number" step="0.01" placeholder="Preis eingeben" required value=
        <?php
        if ($alreadyExist) {
            echo "'" . secPOST("price") . "'";
        } else {
            echo "'$row[price]'";
        }
        ?>><br>
    
    <label for="price_payOut" class="required">
        Auszahlung an Lieferanten (pro <?php echo getSetting('volumeUnit'); ?>):
    </label><br>
    <input id="price_payOut" name="price_payOut" type="number" step="0.01" placeholder="Preis eingeben" required value=
        <?php
        if ($alreadyExist) {
            echo "'" . secPOST("price_payOut") . "'";
        } else {
            echo "'$row[pricePayOut]'";
        }
        ?>><br>
    
    <button>Änderungen speichern</button>
</form>
        <?php
    }
}
    include 'modules/footer.php';
?>