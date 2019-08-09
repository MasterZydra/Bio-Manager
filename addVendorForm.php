<?php
    include 'modules/header.php';
?>

<h1>Lieferanten hinzufügen</h1>

<form action="addVendor.php" method="POST">
    <label>Name:
        <input type="text" placeholder="Name des Lieferanten" name="vendor_name" required>
    </label><br>
    <button type="submit">Hinzufügen</button>
</form>

<?php
    include 'modules/footer.php';
?>
