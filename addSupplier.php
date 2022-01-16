<?php
/*
* addSupplier.php
* ---------------
* This form is used to add a new supplier.
*
* @Author: David Hein
*/
include 'System/Autoloader.php';

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (!isMaintainer()) {
    header("Location: supplier.php");
    exit();
}

include 'Modules/header.php';

use System\Modules\Database\MySQL\MySqlHelpers;
?>
<h1>Lieferanten hinzufügen</h1>

<p>
    <a href="supplier.php">Alle Lieferanten anzeigen</a>
</p>
<?php
    $supplierColl = new \System\Modules\DataObjects\SupplierCollection();
    $alreadyExist = isset($_POST["supplier_name"]) &&
    MySqlHelpers::objectAlreadyExists($supplierColl, secPOST("supplier_name"), 0);
if (isset($_GET['add'])) {
    if ($alreadyExist) {
        echo '<div class="warning">';
        echo 'Der Lieferant <strong>' . secPOST("supplier_name") . '</strong> existiert bereits';
        echo '</div>';
    } else {
        $newSupplier = new \System\Modules\DataObjects\Supplier(0, secPOST("supplier_name"), false);
        if ($supplierColl->add($newSupplier)) {
            echo '<div class="infobox">';
            echo 'Der Lieferant <strong>' . secPOST("supplier_name") . '</strong> wurde hinzugefügt';
            echo '</div>';
        }
    }
}
?>
<form action="?add=1" method="POST" class="requiredLegend">
    <label for="supplier_name" class="required">Name:</label><br>
    <input id="supplier_name" name="supplier_name" type="text" placeholder="Name des Lieferanten" required autofocus
        <?php if ($alreadyExist) {
            echo ' value="' . secPOST("supplier_name") . '"';
        } ?>><br>
    
    <button>Hinzufügen</button>
</form>
<?php
    include 'Modules/footer.php';
?>
