<?php
/*
* addRecipient.php
* ----------------
* This form is used to add a new recipient.
*
* @Author: David Hein
*/
include 'System/Autoloader.php';

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (!isMaintainer()) {
    header("Location: recipient.php");
    exit();
}

include 'Modules/header.php';
?>
<h1>Abnehmer hinzufügen</h1>

<p>
    <a href="recipient.php">Alle Abnehmer anzeigen</a>
</p>
<?php
    $alreadyExist = isset($_POST["recipient_name"]) && alreadyExistsRecipient(secPOST("recipient_name"));
if (isset($_GET['add'])) {
    if ($alreadyExist) {
        echo '<div class="warning">';
        echo 'Der Abnehmer <strong>' . secPOST("recipient_name") . '</strong> existiert bereits';
        echo '</div>';
    } else {
        $conn = new \System\Modules\Database\MySQL\MySql();
        $conn -> dbConnect();

        $NULL = [
            "type" => "null",
            "val" => "null"
        ];

        $recipient_name = [
            "type" => "char",
            "val" => secPOST("recipient_name")
        ];

        $recipient_address = [
            "type" => "char",
            "val" => secPOST("recipient_address")
        ];

        $data = array($NULL, $recipient_name, $recipient_address);

        $conn -> insertInto('T_Recipient', $data);
        $conn -> dbDisconnect();

        echo '<div class="infobox">';
        echo 'Der Abnehmer <strong>' . secPOST("recipient_name") . '</strong> wurde hinzugefügt';
        echo '</div>';
    }
}
?>
<form action="?add=1" method="POST" class="requiredLegend">
    <label for="recipient_name" class="required">Name:</label><br>
    <input id="recipient_name" name="recipient_name" type="text" placeholder="Name des Abnehmers" required autofocus
        <?php if ($alreadyExist) {
            echo ' value="' . secPOST("recipient_name") . '"';
        } ?>><br>
    
    <label for="recipient_address" class="required">Anschrift:</label><br>
    <textarea id="recipient_address" name="recipient_address" placeholder="Adresse des Abnehmers" required><?php
        if ($alreadyExist) {
            echo secPOST("recipient_address");
        }
    ?></textarea><br>
    
    <button>Hinzufügen</button>
</form>
<?php
    include 'Modules/footer.php';
?>

