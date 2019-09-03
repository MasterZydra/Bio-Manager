<?php
/*
* index.php
* ---------
* This page is the entry point. If the visiter is logged out, a description
* of this plattform is displayed. After the login the visiter sees the sections
* with links for viewing, adding and editing data depending on his permissions.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/
    include 'modules/header_everyone.php';
    include 'modules/permissionCheck.php';
    include 'modules/header.php';

    if(!isLoggedIn()) {
?>
<h1>Willkommen beim Bio-Manager</h1>
Der Bio-Manger ist zum Verwalten von Anlieferungen von Lieferanten. Durch die Eingebe der Lieferscheine, Flurstücke und Liefermenge können Rechnungen an die Kelterei und Auswertungen zu Liefermenge und der Verteilung auf Flurstücke erstellt werden.
<?php
    } else {
?>
<h1>Willkommen im Mitgliederbereich</h1>
<?php
        // Links for maintainers
        if(isMaintainer() || isInspector()) {
?>
<h2>
    Datenverwaltung
</h2>

<div class="box">
    <strong>Lieferschein</strong><br>
    <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a>
    <?php if(isMaintainer()) {?><br><a href="addDeliveryNote.php">Lieferschein hinzufügen</a><?php } ?>
</div>

<div class="box">
    <strong>Lieferant</strong><br>
    <a href="supplier.php">Alle Lieferanten anzeigen</a>
    <?php if(isMaintainer()) {?><br><a href="addSupplier.php">Lieferant hinzufügen</a><?php } ?>
</div>

<div class="box">
    <strong>Flurstück</strong><br>
    <a href="plot.php">Alle Flurstücke anzeigen</a>
    <?php if(isMaintainer()) {?><br><a href="addPlot.php">Flurstück hinzufügen</a><?php } ?>
</div>

<div class="box">
    <strong>Rechnung</strong><br>
    <a href="invoice.php">Alle Rechnungen anzeigen</a>
    <?php if(isMaintainer()) {?><br><a href="addInvoice.php">Rechnung hinzufügen</a><?php } ?>
</div>

<div class="box">
    <strong>Produkt</strong><br>
    <a href="product.php">Alle Produkte anzeigen</a>
    <?php if(isMaintainer()) {?><br><a href="addProduct.php">Produkt hinzufügen</a><?php } ?>
</div>

<div class="box">
    <strong>Preis</strong><br>
    <a href="pricing.php">Alle Preise anzeigen</a>
    <?php if(isMaintainer()) {?><br><a href="addPricing.php">Preis hinzufügen</a><?php } ?>
</div>
<?php
        }
?>
<h2>
    Mein Bereich
</h2>

<div class="box">
    <strong>Mein Konto</strong><br>
    <a href="changePwd.php">Passwort ändern</a><br>
    <a href="logout.php">Abmelden</a>
</div>

<?php
        // Links for suppliers
        if(isSupplier()){
?>
<div class="box">
    <strong>Meine Daten</strong><br>
    <a href="showMyDeliveryNote.php">Meine Lieferscheine</a>
</div>
<?php
        }
        // Links for administration
        if(isAdmin()){
?>
<h2>
    Administration
</h2>

<div class="box">
    <strong>Benutzerverwaltung</strong><br>
    <a href="user.php">Alle Benutzer anzeigen</a><br>
    <a href="addUser.php">Benutzer hinzufügen</a> 
</div>

<div class="box">
    <strong>Einstellungen</strong><br>
    <a href="setting.php">Alle Einstellungen anzeigen</a>
    <?php if(isDeveloper()) {?><br><a href="addSetting.php">Einstellung hinzufügen</a><?php } ?>
</div>
<?php
        }
        if(isDeveloper()) {
?>
<h2>
    Entwickler
</h2>
<div class="warning">
    <strong>Verwendung auf eigene Gefahr!</strong>
</div>
<div class="box">
    <a href="developerOptions.php">Entwicklereinstellungen</a>
</div>
<?php
        }
    }
?>
<h2>
    Allgemeines
</h2>
<div class="box">
    <a href="impressum.php">Impressum</a>
    <?php if(isLoggedIn()) {?><br><a href="about.php">Systeminformationen</a><?php } ?>
</div>
<script>
    function colorBoxes() {
        var colors = ['#0E161C', '#3F4045', '#153D6B', '#145C9E', '#11626D', '#2A4D14', '#4a8a16', '#E26D00'];
        $boxes = document.getElementsByClassName('box');
        for(var i = 0; i < $boxes.length; i++) {
            $boxes[i].setAttribute('style', 'background-color: ' + colors[i % colors.length] + ';');
        }
    }
    colorBoxes();
</script>
<?php
    include 'modules/footer.php';
?>
