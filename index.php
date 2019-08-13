<?php
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
        if(isMaintainer()) {
?>
<div>
    <strong>Lieferant</strong><br>
    <a href="supplier.php">Alle Lieferanten anzeigen</a><br>
    <a href="addSupplier.php">Lieferant hinzufügen</a>
</div>

<div>
    <strong>Lieferschein</strong><br>
    <a href="deliveryNote.php">Alle Lieferscheine anzeigen</a><br>
    <!--<a href="addDeliveryNoter.php">Lieferanten hinzufügen</a>-->
</div>
<?php
        }
?>
<div>
    <strong>Mein Konto</strong><br>
    <a href="changePwd.php">Passwort ändern</a>
</div>

<?php
        // Links for administration
        if(isAdmin()){
?>
<h2>
    Administration
</h2>

<div>
    <strong>Benutzerverwaltung</strong><br>
    <a href="user.php">Alle Benutzer anzeigen</a><br>
    <a href="addUser.php">Benutzer hinzufügen</a> 
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
<div>
    <a href="developerOptions.php">Entwicklereinstellungen</a>
</div>
<?php
        }
    }
    include 'modules/footer.php';
?>
