<?php
/*
* editInvoiceData.php
* -------------------
* This form is used to edit the data for invoice data.
*
* @Author: David Hein
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';
    
    // Check permission
    if(!isAdmin()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/formHelper.php';
?>

<h1>Rechnungsdaten bearbeiten</h1>

<?php
    if(isset($_GET['edit'])) {
        // --- Write new imprint data in config file ---
        $myfile = fopen("./config/InvoiceDataConfig.php", "w");
        // Create file content
        $txt = '<?php
    // Configuration for data which will be shown in invoice
    // Important: Use web interface to change the data. This file will be written from there.
    $invoice["sender_name"] = "' . secPOST('sender_name') . '";
    $invoice["sender_address"] = "' . secPOST('sender_address') . '";
    $invoice["sender_postalCode"] = "' . secPOST('sender_postalCode') . '";
    $invoice["sender_city"] = "' . secPOST('sender_city') . '";
    $invoice["bank"] = "' . secPOST('bank') . '";
    $invoice["BIC"] = "' . secPOST('BIC') . '";
    $invoice["IBAN"] = "' . str_replace(' ', '', secPOST('IBAN')) . '";
    $invoice["author"] = "' . secPOST('author') . '";
    $invoice["name"] = "' . secPOST('name') . '";
?>';
        fwrite($myfile, $txt);
        fclose($myfile);

        echo '<div class="infobox">';
        echo 'Die Änderungen wurden erfolgreich gespeichert';
        echo '</div>';
        // Include after writing so the new content will be shown in form        
        include 'config/InvoiceDataConfig.php';
    } else {
        // Check if file exists to prevent warnings
        if (file_exists('config/InvoiceDataConfig.php'))
            include 'config/InvoiceDataConfig.php';    
    }
    $invoice = $invoice ?? NULL;
?>
<form action="?edit=1" method="post" class="requiredLegend">
    <h2>Allgemeines</h2>
<?php
    generateArrayField($invoice, "author", "text", "Autor", "Vorname Nachname", true);
    generateArrayField($invoice, "name", "text", "Dokumentname", "Rechnung", true);
?>
    
    <h2>Absender</h2>
<?php
    generateArrayField($invoice, "sender_name", "text", "Name", "Vorname Nachname", true);
    generateArrayField($invoice, "sender_address", "text", "Straße", "Straße Hausnummer");
    generateArrayField($invoice, "sender_postalCode", "number", "Postleitzahl", "Postleitzahl");
    generateArrayField($invoice, "sender_city", "text", "Stadt", "Stadt");
?>
    
    <h2>Bankdaten</h2>
<?php
    generateArrayField($invoice, "bank", "text", "Bank", "Bankname");
    generateArrayField($invoice, "BIC", "text", "BIC", "BIC");
    generateArrayField($invoice, "IBAN", "text", "IBAN", "IBAN");
?>
    
    <button>Änderungen speichern</button>
</form>
<?php
    include 'modules/footer.php';
?>