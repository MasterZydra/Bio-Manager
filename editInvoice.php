<?php
/*
* editInvoice.php
* ---------------
* This form is used to edit an invoice.
*
* @Author: David Hein
*/
include 'modules/header_user.php';
include 'modules/PermissionCheck.php';

// Check permission
if (
    !isMaintainer() ||
        // Check if id is numeric
        (isset($_GET['id']) && !is_numeric($_GET['id']))
) {
    header("Location: invoice.php");
    exit();
}

include 'modules/header.php';

include 'modules/selectBox_BioManager.php';

include_once 'modules/MySqlPreparedStatementBioManager.php';
?>

<h1>Rechnung bearbeiten</h1>

<p>
    <a href="invoice.php">Alle Rechnungen anzeigen</a>
</p>

<?php
if (!isset($_GET['id'])) {
    echo '<div class="warning">';
    echo 'Es wurde keine Rechnung übergeben. Zurück zu <a href="invoice.php">Alle Rechnungen anzeigen</a>';
    echo '</div>';
} else {
    $conn = new Mysql();
    $conn -> dbConnect();

    $conn -> select('T_Invoice', 'isPaid', 'id = ' . secGET('id'));
    $row = $conn -> getFirstRow();

    if (!$row['isPaid'] && isset($_GET['edit'])) {
        $conn -> update(
            'T_Invoice',
            'invoiceDate = \'' . secPOST('invoiceDate') . '\', '
            . 'isPaid = ' . secPOST('invoiceIsPaid') . ', '
            . 'recipientId = ' . secPOST('recipientId'),
            'id = ' . secGET('id')
        );
        echo '<div class="infobox">';
        echo 'Die Änderungen wurden erfolgreich gespeichert';
        echo '</div>';
    }

    $conn -> dbDisconnect();
    $conn = null;

    // Select data
    $prepStmt = new MySqlPreparedStatementBioManager();
    $row = $prepStmt -> selectWhereId("T_Invoice", secGET('id'));
    $prepStmt -> destroy();

    // Check if id is valid
    if ($row == null) {
        echo '<div class="warning">';
        echo 'Die ausgewählte Rechnung wurde in der Datenbank nicht gefunden.';
        echo 'Zurück zu <a href="invoice.php">Alle Rechnungen anzeigen</a>';
        echo '</div>';
    } else {
        // Show message if invoice is paid
        if ($row['isPaid']) {
            echo '<div class="warning">';
            echo 'Die Rechnung darf nicht mehr bearbeitet werden';
            echo '</div>';
        }
        ?>
<form action="?id=<?php echo $row['id']; ?>&edit=1" method="post" class="requiredLegend">
    <label>Jahr:<br>
        <input type="number" name="invoiceYear" value="<?php echo $row['year']; ?>" readonly>
    </label><br>
    
    <label>Nr:<br>
        <input type="number" name="invoiceNr" value="<?php echo $row['nr']; ?>" readonly>
    </label><br>
    
    <label for="invoiceDate" class="required">Rechnungsdatum:</label><br>
    <input id="invoiceDate" name="invoiceDate" type="date" placeholder="Rechnungsdatum geben"
        value="<?php echo $row['invoiceDate']; ?>"
        <?php echo ($row['isPaid']) ? ' readonly' : ' required autofocus'; ?>><br>
    
    <label for="recipientId" class="required">Abnehmer:</label><br>
        <?php
        if ($row['isPaid']) {
            echo recipientSelectBox(null, $row['recipientId'], true);
        } elseif (isset($_POST['recipientId'])) {
            echo recipientSelectBox(null, secPOST('recipientId'));
        } else {
            echo recipientSelectBox(null, $row['recipientId']);
        }
        ?><br>
    
    <label>
        <input type="hidden" name="invoiceIsPaid" value="0">
        <input type="checkbox" name="invoiceIsPaid" value="1"
           <?php echo ($row['isPaid']) ? 'checked onclick="return false;"' : ''; ?>>
        Ist bezahlt
    </label><br>
    
    <button <?php echo ($row['isPaid']) ? ' disabled' : ''; ?>>Änderungen speichern</button>
</form>
        <?php
    }
}
    include 'modules/footer.php';
?>