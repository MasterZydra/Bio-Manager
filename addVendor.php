<?php
    include 'modules/header_user.php';
    include 'modules/header.php';
?>
<h1>Lieferanten hinzufügen</h1>

<p>
    <a href="vendors.php">Alle Lieferanten anzeigen</a>
</p>
<?php
    if(isset($_GET['add'])) {
        include 'modules/Mysql.php';
        include 'modules/helperFunctions.php';
        
        $conn = new Mysql();
        $conn -> dbConnect();
        
        $NULL = [
            "type" => "null",
            "val" => "null"
        ];
        
        $vendor_name = [
            "type" => "char",
            "val" => $_POST["vendor_name"]
        ];
        
        $data = array($NULL, $vendor_name);
        
        $conn -> insertInto('T_Vendor', $data);
        $conn -> dbDisconnect();
        
        echo '<div class="infobox">';
        echo 'Der Lieferant <strong>' . $_POST["vendor_name"] . '</strong> wurde hinzugefügt';
        echo '</div>';
    }
?>
<form action="?add=1" method="POST">
    <label>Name:
        <input type="text" placeholder="Name des Lieferanten" name="vendor_name" required>
    </label><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>
