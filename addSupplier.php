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
    if(isset($_GET['add'])) {
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
        
        $data = array($NULL, $supplier_name);
        
        $conn -> insertInto('T_Supplier', $data);
        $conn -> dbDisconnect();
        
        echo '<div class="infobox">';
        echo 'Der Lieferant <strong>' . $_POST["supplier_name"] . '</strong> wurde hinzugefügt';
        echo '</div>';
    }
?>
<form action="?add=1" method="POST">
    <label>Name:<br>
        <input type="text" placeholder="Name des Lieferanten" name="supplier_name" required>
    </label><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>