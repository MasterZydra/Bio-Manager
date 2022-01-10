<?php
/*
* recipient.php
* -------------
* This page shows all recipients in a table. A filter can
* be used to find the wanted rows. With maintainer permissions
* the user can delete, edit and add a recipient.
*
* @Author: David Hein
*/

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (
    !isMaintainer() && !isInspector() ||
        // Check if id is numeric
        (isset($_GET['id']) && !is_numeric($_GET['id']))
) {
    header("Location: index.php");
    exit();
}

include 'Modules/header.php';

include 'Modules/TableGenerator.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>

<h1>Abnehmer</h1>
<p>
    <?php if (isMaintainer()) {
        ?><a href="addRecipient.php">Abnehmer hinzufügen</a><?php
    } ?>  
</p>

<?php
if (isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
    switch (secGET('action')) {
        case 'delete':
            // Action - Delete
            echo '<script>window.location.replace("deleteRecipient.php?id=' . secGET('id') . '");</script>';
            break;
        case 'edit':
            // Action - Edit
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editRecipient.php?id=' . secGET('id') . '");</script>';
            break;
    }
}
?>

<p>
    <input type="text" id="filterInput-tableRecipient" placeholder="Suchtext eingeben..." title="Suchtext"
    onkeyup="filterData(&quot;tableRecipient&quot;)" />
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select('T_Recipient', '*');
    $conn -> dbDisconnect();
    $conn = null;

if (isMaintainer()) {
    TableGenerator::show(
        'dataTable-tableRecipient',
        $result,
        array('name', 'address'),
        array('Name', 'Adresse', 'Aktionen'),
        array('edit', 'delete'),
        array('Bearbeiten', 'Löschen')
    );
} else {
    TableGenerator::show(
        'dataTable-tableRecipient',
        $result,
        array('name', 'address'),
        array('Name', 'Adresse')
    );
}

include 'Modules/footer.php';
?>