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
* 
* Changelog:
* ----------
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isAdmin() ||
       // Check if id is numeric
       (isset($_GET['id']) && !is_numeric($_GET['id'])))
    {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/tableGenerator.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>

<h1>Einstellung</h1>
<?php
    if(isDeveloper()) {
?>
<p>
    <a href="addSetting.php">Einstellung hinzufügen</a>    
</p>
<?php
    }
?>

<?php
    if(isset($_GET['action']) && isset($_GET['id'])) {
        if(secGET('action') == 'edit') {
            // Action - Edit setting
            // Forwording to edit page and add parameters
            echo '<script>window.location.replace("editSetting.php?id=' . secGET('id') . '");</script>';
        } elseif(isDeveloper() && secGET('action') == 'delete') {
            // Action - Delete
            echo '<script>window.location.replace("deleteSetting.php?id=' . secGET('id') . '");</script>';
        }
    }
?>

<p>
    <input type="text" id="filterInput-tableSetting" onkeyup="filterData(&quot;tableSetting&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select('T_Setting', '*', NULL, 'description ASC');
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isDeveloper()) {
        tableGenerator::show(
            'dataTable-tableSetting',
            $result,
            array('name', 'description', 'value'),
            array('Einstellung', 'Beschreibung', 'Wert', 'Aktionen'),
            array('edit', 'delete'),
            array('Bearbeiten', 'Löschen'));
    } else {
        tableGenerator::show(
            'dataTable-tableSetting',
            $result,
            array('name', 'description', 'value'),
            array('Einstellung', 'Beschreibung', 'Wert', 'Aktionen'),
            array('edit'),
            array('Bearbeiten'));
    }

    include 'modules/footer.php';
?>