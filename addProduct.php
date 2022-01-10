<?php
/*
* addProduct.php
* ---------------
* This form is used to add a new product.
*
* @Author: David Hein
*/

include 'System/Autoloader.php';

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (!isMaintainer()) {
    header("Location: product.php");
    exit();
}

include 'Modules/header.php';

use System\Modules\Database\MySQL\MySqlHelpers;
?>
<h1>Produkt hinzufügen</h1>

<p>
    <a href="product.php">Alle Produkte anzeigen</a>
</p>
<?php
    $productColl = new \System\Modules\DataObjects\ProductCollection();
    $alreadyExist = isset($_POST["product_name"]) &&
        MySqlHelpers::objectAlreadyExists($productColl, secPOST("product_name"), 0);
if (isset($_GET['add'])) {
    if ($alreadyExist) {
        echo '<div class="warning">';
        echo 'Das Produkt <strong>' . secPOST("product_name") . '</strong> existiert bereits';
        echo '</div>';
    } else {
        $newProduct = new \System\Modules\DataObjects\Product(0, secPOST("product_name"));
        if ($productColl->add($newProduct)) {
            echo '<div class="infobox">';
            echo 'Das Produkt <strong>' . secPOST("product_name") . '</strong> wurde hinzugefügt';
            echo '</div>';
        }
    }
}
?>
<form action="?add=1" method="POST" class="requiredLegend">
    <label for="product_name" class="required">Name:</label><br>
    <input id="product_name" name="product_name"  type="text" placeholder="Name des Produktes" required autofocus
        <?php if ($alreadyExist) {
            echo ' value="' . secPOST("product_name") . '"';
        } ?>><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'Modules/footer.php';
?>

