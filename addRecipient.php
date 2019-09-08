<?php
/*
* addRecipient.php
* ----------------
* This form is used to add a new recipient.
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
<h1>Abnehmer hinzufügen</h1>

<p>
    <a href="recipient.php">Alle Lieferanten anzeigen</a>
</p>
<?php
    $alreadyExist = isset($_POST["recipient_name"]) && alreadyExistsRecipient($_POST["recipient_name"]);
    if(isset($_GET['add'])) {
        if($alreadyExist) {
            echo '<div class="warning">';
            echo 'Der Abnehmer <strong>' . $_POST["recipient_name"] . '</strong> existiert bereits';
            echo '</div>';
        } else {
            $conn = new Mysql();
            $conn -> dbConnect();

            $NULL = [
                "type" => "null",
                "val" => "null"
            ];

            $recipient_name = [
                "type" => "char",
                "val" => $_POST["recipient_name"]
            ];

            $recipient_address = [
                "type" => "char",
                "val" => $_POST["recipient_address"]
            ];

            $data = array($NULL, $recipient_name, $recipient_address);

            $conn -> insertInto('T_Recipient', $data);
            $conn -> dbDisconnect();

            echo '<div class="infobox">';
            echo 'Der Abnehmer <strong>' . $_POST["recipient_name"] . '</strong> wurde hinzugefügt';
            echo '</div>';
        }
    }
?>
<form action="?add=1" method="POST">
        <label>Name:<br>
        <input type="text" placeholder="Name des Abnehmers" name="recipient_name" required autofocus
            <?php if($alreadyExist) { echo ' value="' . $_POST["recipient_name"] . '"'; } ?>>
    </label><br>
    <label>Anschrift:<br>
        <textarea name="recipient_address" placeholder="Adresse des Abnehmers" required><?php if($alreadyExist) { echo $_POST["recipient_address"]; } ?></textarea>
    </label><br>
    <button>Hinzufügen</button>
</form>
<?php
    include 'modules/footer.php';
?>

