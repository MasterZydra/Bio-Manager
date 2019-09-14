<?php
/*
* editRecipient.php
* -----------------
* This form is used to edit a recipient.
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
        header("Location: recipient.php");
        exit();
    }

    include 'modules/header.php';
?>

<h1>Abnehmer bearbeiten</h1>

<p>
    <a href="recipient.php">Alle Abnehmer anzeigen</a>    
</p>

<?php
    $alreadyExist = false;
    if(!isset($_GET['id'])) {
        echo '<div class="warning">';
        echo 'Es wurde kein Abnehmer übergeben. Zurück zu <a href="recipient.php">Alle Abnehmer anzeigen</a>';
        echo '</div>';
    } else {
        $conn = new Mysql();
        $conn -> dbConnect();
        
        $alreadyExist = isset($_POST["recipient_name"]) && alreadyExistsRecipient($_POST["recipient_name"], $_GET['id']);
        if(isset($_GET['edit'])) {
            if($alreadyExist) {
                echo '<div class="warning">';
                echo 'Der Abnehmer <strong>' . $_POST["recipient_name"] . '</strong> existiert bereits';
                echo '</div>';
            } else {
                $conn -> update(
                    'T_Recipient',
                    'name = \'' . $_POST['recipient_name'] . '\', '
                    . 'address = \'' . $_POST['recipient_address'] . '\'',
                    'id = ' . $_GET['id']);
                echo '<div class="infobox">';
                echo 'Die Änderungen wurden erfolgreich gespeichert';
                echo '</div>';
            }
        }

        $conn -> select('T_Recipient', '*', 'id = ' . $_GET['id']);
        $row = $conn -> getFirstRow();
        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Check if id is valid 
        if ($row == NULL) {
            echo '<div class="warning">';
            echo 'Der ausgewählte Abnehmer wurde in der Datenbank nicht gefunden. Zurück zu <a href="recipient.php">Alle Abnehmer anzeigen</a>';
            echo '</div>';
        } else {
?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post" class="requiredLegend">
    <label for="recipient_name" class="required">Name:</label><br>
    <input id="recipient_name" name="recipient_name" type="text" placeholder="Name des Abnehmers" required autofocus value=
        <?php
            if($alreadyExist) {
                echo '"' . $_POST["recipient_name"] . '"';
            } else {
                echo '"' . $row['name'] . '"';
            }
        ?>><br>
    
    <label for="recipient_address" class="required">Anschrift:</label><br>
    <textarea id="recipient_address" name="recipient_address" placeholder="Adresse des Abnehmers" required><?php if($alreadyExist) { echo $_POST["recipient_address"]; } else { echo $row['address']; } ?></textarea><br>
    <button>Änderungen speichern</button>
</form>
<?php
        }
    }
    include 'modules/footer.php';
?>