<?php
/*
* setting.php
* ----------------
* This page shows all settings in a table. A filter can
* be used to find the wanted rows. A user needs
* administrator permissions to see and edit the users.
* Only developer can add settings.
*
* @Author: David Hein
*/
include 'System/Autoloader.php';

include 'Modules/header_user.php';
include 'Modules/PermissionCheck.php';

// Check permission
if (
    !isAdmin() ||
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

<h1>Einstellung</h1>
<?php
if (isDeveloper()) {
    ?>
<p>
    <a href="addSetting.php">Einstellung hinzufügen</a>    
</p>
    <?php
}
?>

<?php
if (isset($_GET['action']) && isset($_GET['id'])) {
    if (secGET('action') == 'edit') {
        // Action - Edit setting
        // Forwording to edit page and add parameters
        echo '<script>window.location.replace("editSetting.php?id=' . secGET('id') . '");</script>';
    } elseif (isDeveloper() && secGET('action') == 'delete') {
        // Action - Delete
        echo '<script>window.location.replace("deleteSetting.php?id=' . secGET('id') . '");</script>';
    }
}
?>

<p>
    <input type="text" id="filterInput-tableSetting" placeholder="Suchtext eingeben..." title="Suchtext"
    onkeyup="filterData(&quot;tableSetting&quot;)" />
</p>

<?php
    $conn = new \System\Modules\Database\MySQL\MySql();
    $conn -> dbConnect();
    $result = $conn -> select('T_Setting', '*', null, 'description ASC');
    $conn -> dbDisconnect();
    $conn = null;

if (isDeveloper()) {
    TableGenerator::show(
        'dataTable-tableSetting',
        $result,
        array('name', 'description', 'value'),
        array('Einstellung', 'Beschreibung', 'Wert', 'Aktionen'),
        array('edit', 'delete'),
        array('Bearbeiten', 'Löschen')
    );
} else {
    TableGenerator::show(
        'dataTable-tableSetting',
        $result,
        array('name', 'description', 'value'),
        array('Einstellung', 'Beschreibung', 'Wert', 'Aktionen'),
        array('edit'),
        array('Bearbeiten')
    );
}

include 'Modules/footer.php';
?>