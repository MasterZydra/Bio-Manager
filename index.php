<?php
    include 'modules/header_everyone.php';
    include 'modules/header.php';

    if(!isset($_SESSION['userId'])) {
?>
<h1>Willkommen beim Bio-Manager</h1>
Der Bio-Manger ist zum Verwalten von Anlieferungen von Lieferanten. Durch die Eingebe der Lieferscheine, Flurstücke und Liefermenge können Rechnungen an die Kelterei und Auswertungen zu Liefermenge und der Verteilung auf Flurstücke erstellt werden.
<?php
    } else {
?>
<h1>Willkommen im Mitgliederbereich</h1>

<div>
    <strong>Lieferanten</strong><br>
    <a href="vendor.php">Alle Lieferanten anzeigen</a><br>
    <a href="addVendor.php">Lieferanten hinzufügen</a>
</div>

<div>
    <strong>Mein Konto</strong><br>
    <a href="changePwd.php">Passwort ändern</a>
</div>

<?php
    }
    include 'modules/footer.php';
?>
