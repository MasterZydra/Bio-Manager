<?php
/*
* editRecipient.php
* -----------------
* This form is used to edit a recipient.
*
* @Author: David Hein
*/
    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';
    
    // Check permission
    if(!isMaintainer() ||
       // Check if id is numeric
       (isset($_GET['id']) && !is_numeric($_GET['id'])))
    {
        header("Location: recipient.php");
        exit();
    }

    include 'modules/header.php';

    include_once 'modules/Mysql_preparedStatement_BioManager.php';
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
        
        $alreadyExist = isset($_POST["recipient_name"]) && alreadyExistsRecipient(secPOST("recipient_name"), secGET('id'));
        if(isset($_GET['edit'])) {
            if($alreadyExist) {
                echo '<div class="warning">';
                echo 'Der Abnehmer <strong>' . secPOST("recipient_name") . '</strong> existiert bereits';
                echo '</div>';
            } else {
                $conn -> update(
                    'T_Recipient',
                    'name = \'' . secPOST('recipient_name') . '\', '
                    . 'address = \'' . secPOST('recipient_address') . '\'',
                    'id = ' . secGET('id'));
                echo '<div class="infobox">';
                echo 'Die Änderungen wurden erfolgreich gespeichert';
                echo '</div>';
            }
        }

        $conn -> dbDisconnect();
        $conn = NULL;
        
        // Select data
        $prepStmt = new mysql_preparedStatement_BioManager();
        $row = $prepStmt -> selectWhereId("T_Recipient", secGET('id'));
        $prepStmt -> destroy();
        
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
            echo ($alreadyExist) ? '"' . secPOST("recipient_name") . '"' : '"' . $row['name'] . '"';
        ?>><br>
    
    <label for="recipient_address" class="required">Anschrift:</label><br>
    <textarea id="recipient_address" name="recipient_address" placeholder="Adresse des Abnehmers" required>
<?php if($alreadyExist) { echo secPOST("recipient_address"); } else { echo $row['address']; } ?>
</textarea><br>
    
    <button>Änderungen speichern</button>
</form>
<?php
        }
    }
    include 'modules/footer.php';
?>