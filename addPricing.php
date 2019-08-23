<?php
/*
* addPricing.php
* --------------
* This form is used to add a new pricing.
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
        header("Location: pricing.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/selectBox_BioManager.php';
?>
<h1>Preis hinzufügen</h1>

<p>
    <a href="pricing.php">Alle Preise anzeigen</a>
</p>
<?php
    if(isset($_GET['add'])) {
        $conn = new Mysql();
        $conn -> dbConnect();
        
        $NULL = [
            "type" => "null",
            "val" => "null"
        ];
        
        $productId = [
            "type" => "int",
            "val" => $_POST["productId"]
        ];
        
        $price_year = [
            "type" => "int",
            "val" => $_POST["price_year"]
        ];
        
        $price_price = [
            "type" => "int",
            "val" => $_POST["price"]
        ];
        
        $price_payOut = [
            "type" => "int",
            "val" => $_POST["price_outPay"]
        ];

        $data = array($NULL, $productId, $price_year, $price_price, $price_payOut);
        
        $conn -> insertInto('T_Pricing', $data);
        $conn -> dbDisconnect();
        
        echo '<div class="infobox">';
        echo 'Der Preis wurde hinzugefügt';
        echo '</div>';
    }
?>
<form action="?add=1" method="POST">
    <label>Jahr:<br>
        <input type="number" name="price_year" value="<?php echo date("Y"); ?>" required autofocus>
    </label><br>
    <label>Produkt:<br>
        <?php echo productSelectBox(); ?>
    </label><br>
    <label>Preis:<br>
        <input type="number" step="0.01" name="price" placeholder="Preis eingeben" required>
    </label><br>
    <label>Auszahlung an Lieferanten:<br>
        <input type="number" step="0.01" name="price_outPay" placeholder="Preis eingeben" required>
    </label><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>
