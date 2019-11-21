<?php
/*
* editImpressum.php
* ---------------
* This form is used to edit the contents in the impressum.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';
    
    // Check permission
    if(!isAdmin()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';
?>

<h1>Impressum bearbeiten</h1>

<?php
    if(isset($_GET['edit'])) {
        $myfile = fopen("./config/ImpressumConfig.php", "w") or die("Unable to open file!");
         $txt = '<?php
    // Configuration for data which will be shown in impressum
    // Important: Use web interface to change the data. This file will be written from there.
    $impressum["provider_name"] = "' . $_POST['provider_name'] . '";
    $impressum["provider_street"] = "' . $_POST['provider_street'] . '";
    $impressum["provider_postalCode"] = "' . $_POST['provider_postalCode'] . '";
    $impressum["provider_city"] = "' . $_POST['provider_city'] . '";
    $impressum["provider_email"] = "' . $_POST['provider_email'] . '";

    $impressum["responsible_name"] = "' . $_POST['responsible_name'] . '";
    $impressum["responsible_street"] = "' . $_POST['responsible_street'] . '";
    $impressum["responsible_postalCode"] = "' . $_POST['responsible_postalCode'] . '";
    $impressum["responsible_city"] = "' . $_POST['responsible_city'] . '";
    $impressum["responsible_email"] = "' . $_POST['responsible_email'] . '";
?>';
        fwrite($myfile, $txt);
        fclose($myfile);

        echo '<div class="infobox">';
        echo 'Die Änderungen wurden erfolgreich gespeichert';
        echo '</div>';
        
        include 'config/ImpressumConfig.php';
    } else {
        include 'config/ImpressumConfig.php';    
    }
?>
<form action="?edit=1" method="post" class="requiredLegend">
    <h2>Anbieter (Privatperson oder Unternehmen)</h2>
    <label for="provider_name" class="required">Name:</label><br>
    <input type="text"
        id="provider_name" name="provider_name"
        placeholder="Vorname Nachname" value="<?php echo $impressum['provider_name']; ?>"
        required autofocus><br>

    <label for="provider_street" class="required">Straße:</label><br>
    <input type="text"
        id="provider_street" name="provider_street"
        placeholder="Straße Hausnummer" value="<?php echo $impressum['provider_street']; ?>"
        required><br>
    
    <label for="provider_postalCode" class="required">Postleitzahl:</label><br>
    <input type="number"
        id="provider_postalCode" name="provider_postalCode"
        placeholder="Postleitzahl" value="<?php echo $impressum['provider_postalCode']; ?>"
        required><br>

    <label for="provider_city" class="required">Stadt:</label><br>
    <input type="text"
        id="provider_city" name="provider_city"
        placeholder="Stadt" value="<?php echo $impressum['provider_city']; ?>"
        required><br>
    
    <label for="provider_email" class="required">Email:</label><br>
    <input type="email"
        id="provider_email" name="provider_email"
        placeholder="Email" value="<?php echo $impressum['provider_email']; ?>"
        required><br>
    
    <h2>Datenschutzbeauftragter</h2>
    <label for="responsible_name" class="required">Name:</label><br>
    <input type="text"
        id="responsible_name" name="responsible_name"
        placeholder="Vorname Nachname" value="<?php echo $impressum['responsible_name']; ?>"
        required autofocus><br>

    <label for="responsible_street" class="required">Straße:</label><br>
    <input type="text"
        id="responsible_street" name="responsible_street"
        placeholder="Straße Hausnummer" value="<?php echo $impressum['responsible_street']; ?>"
        required><br>
    
    <label for="responsible_postalCode" class="required">Postleitzahl:</label><br>
    <input type="number"
        id="responsible_postalCode" name="responsible_postalCode"
        placeholder="Postleitzahl" value="<?php echo $impressum['responsible_postalCode']; ?>"
        required><br>

    <label for="responsible_city" class="required">Stadt:</label><br>
    <input type="text"
        id="responsible_city" name="responsible_city"
        placeholder="Stadt" value="<?php echo $impressum['responsible_city']; ?>"
        required><br>
    
    <label for="responsible_email" class="required">Email:</label><br>
    <input type="email"
        id="responsible_email" name="responsible_email"
        placeholder="Email" value="<?php echo $impressum['responsible_email']; ?>"
        required><br>
    
    <button>Änderungen speichern</button>
</form>
<?php
    include 'modules/footer.php';
?>