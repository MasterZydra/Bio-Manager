<?php
/*
* editProduct.php
* ---------------
* This form is used to edit a product.
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

<h1>Produkt bearbeiten</h1>

<p>
    <a href="product.php">Alle Produkte anzeigen</a>    
</p>

<?php
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Produkt übergeben. Zurück zu <a href="product.php">Alle Produkte anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        if(isset($_GET['edit'])) {
            $conn -> update(
                'T_Product',
                'name = \'' . $_POST['product_name'] . '\'',
                'id = ' . $_GET['id']);
            echo '<div class="infobox">';
            echo 'Die Änderungen wurden erfolgreich gespeichert';
            echo '</div>';
        }

        $conn -> select('T_Product', '*', 'id = ' . $_GET['id']);
        $row = $conn -> getFirstRow();
        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Das ausgewählte Produkt wurde in der Datenbank nicht gefunden. Zurück zu <a href="product.php">Alle Produkte anzeigen</a>';
            echo '</div>';
        }
    }
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post">
    <label>Name:<br>
        <input type="text" name="product_name" value="<?php echo $row['name']; ?>" required autofocus>
    </label><br>
    <button>Änderungen speichern</button>
</form>
<?php
    include 'modules/footer.php';
?>