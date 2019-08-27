<?php
/*
* addProduct.php
* ---------------
* This form is used to add a new product.
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
        header("Location: product.php");
        exit();
    }

    include 'modules/header.php';
?>
<h1>Produkt hinzufügen</h1>

<p>
    <a href="product.php">Alle Produkte anzeigen</a>
</p>
<?php
    $alreadyExist = isset($_POST["product_name"]) && alreadyExistsProduct($_POST["product_name"]);
    if(isset($_GET['add'])) {
        if($alreadyExist) {
            echo '<div class="warning">';
            echo 'Das Produkt <strong>' . $_POST["product_name"] . '</strong> existiert bereits';
            echo '</div>';
        } else {
            $conn = new Mysql();
            $conn -> dbConnect();

            $NULL = [
                "type" => "null",
                "val" => "null"
            ];

            $product_name = [
                "type" => "char",
                "val" => $_POST["product_name"]
            ];

            $data = array($NULL, $product_name);

            $conn -> insertInto('T_Product', $data);
            $conn -> dbDisconnect();

            echo '<div class="infobox">';
            echo 'Das Produkt <strong>' . $_POST["product_name"] . '</strong> wurde hinzugefügt';
            echo '</div>';
        }
    }
?>
<form action="?add=1" method="POST">
    <label>Name:<br>
        <input type="text" placeholder="Name des Produktes" name="product_name" required autofocus>
    </label><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>

