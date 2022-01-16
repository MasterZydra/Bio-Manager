<?php
/*
* addPricing.php
* --------------
* This form is used to add a new pricing.
*
* @Author: David Hein
*/
include 'System/Autoloader.php';

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (!isMaintainer()) {
    header("Location: pricing.php");
    exit();
}

include 'Modules/header.php';

include 'Modules/selectBox_BioManager.php';
?>
<h1>Preis hinzufügen</h1>

<p>
    <a href="pricing.php">Alle Preise anzeigen</a>
</p>
<?php
    $alreadyExist = isset($_POST["productId"]) && isset($_POST["price_year"]) &&
        alreadyExistsPricing(secPOST("productId"), secPOST("price_year"));
if (isset($_GET['add'])) {
    if ($alreadyExist) {
        echo '<div class="warning">';
        echo 'Der Preis existiert bereits';
        echo '</div>';
    } else {
        $conn = new \System\Modules\Database\MySQL\MySql();
        $conn -> dbConnect();

        $NULL = [
            "type" => "null",
            "val" => "null"
        ];

        $productId = [
            "type" => "int",
            "val" => secPOST("productId")
        ];

        $price_year = [
            "type" => "int",
            "val" => secPOST("price_year")
        ];

        $price_price = [
            "type" => "int",
            "val" => secPOST("price")
        ];

        $price_payOut = [
            "type" => "int",
            "val" => secPOST("price_outPay")
        ];

        $data = array($NULL, $productId, $price_year, $price_price, $price_payOut);

        $conn -> insertInto('T_Pricing', $data);
        $conn -> dbDisconnect();

        echo '<div class="infobox">';
        echo 'Der Preis wurde hinzugefügt';
        echo '</div>';
    }
}
?>
<form action="?add=1" method="POST" class="requiredLegend">
    <label for="price_year" class="required">Jahr:</label><br>
    <input id="price_year" name="price_year" type="number" value="<?php echo date("Y"); ?>" required autofocus
        <?php if ($alreadyExist) {
            echo ' value="' . secPOST("price_year") . '"';
        } ?>><br>
    
    <label for="productId" class="required">Produkt:</label><br>
    <?php
    if ($alreadyExist) {
        echo productSelectBox(null, secPOST("productId"));
    } else {
        echo productSelectBox();
    }
    ?><br>
    
    <label for="price" class="required">Preis (pro <?php echo getSetting('volumeUnit'); ?>):</label><br>
    <input id="price" name="price" type="number" step="0.01" placeholder="Preis eingeben" required
           <?php if ($alreadyExist) {
                echo ' value="' . secPOST("price") . '"';
           } ?>><br>
    
    <label for="price_outPay" class="required">
        Auszahlung an Lieferanten (pro <?php echo getSetting('volumeUnit'); ?>):
    </label><br>
    <input id="price_outPay" name="price_outPay" type="number" step="0.01" placeholder="Preis eingeben" required
           <?php if ($alreadyExist) {
                echo ' value="' . secPOST("price_outPay") . '"';
           } ?>><br>
    
    <button>Hinzufügen</button>
</form>
<?php
    include 'Modules/footer.php';
?>
