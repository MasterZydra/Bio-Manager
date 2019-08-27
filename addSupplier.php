<?php
/*
* addSupplier.php
* ---------------
* This form is used to add a new supplier.
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
        header("Location: supplier.php");
        exit();
    }

    include 'modules/header.php';
?>
<h1>Lieferanten hinzufügen</h1>

<p>
    <a href="supplier.php">Alle Lieferanten anzeigen</a>
</p>
<?php
    $alreadyExist = isset($_POST["supplier_name"]) && alreadyExistSupplier($_POST["supplier_name"]);
    if(isset($_GET['add'])) {
        if($alreadyExist) {
            echo '<div class="warning">';
            echo 'Der Lieferant <strong>' . $_POST["supplier_name"] . '</strong> existiert bereits';
            echo '</div>';
        } else {
            $conn = new Mysql();
            $conn -> dbConnect();

            $NULL = [
                "type" => "null",
                "val" => "null"
            ];

            $supplier_name = [
                "type" => "char",
                "val" => $_POST["supplier_name"]
            ];

            $supplier_inactive = [
                "type" => "char",
                "val" => "0"
            ];

            $data = array($NULL, $supplier_name, $supplier_inactive);

            $conn -> insertInto('T_Supplier', $data);
            $conn -> dbDisconnect();

            echo '<div class="infobox">';
            echo 'Der Lieferant <strong>' . $_POST["supplier_name"] . '</strong> wurde hinzugefügt';
            echo '</div>';
        }
    }
?>
<form action="?add=1" method="POST">
    <label>Name:<br>
        <input type="text" placeholder="Name des Lieferanten" name="supplier_name" required autofocus>
    </label><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>
