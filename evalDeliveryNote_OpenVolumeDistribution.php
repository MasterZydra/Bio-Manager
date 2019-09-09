<?php
/*
* evalDeliveryNote.php
* --------------------
* This page shows an evaluation which delivery notes
* have no or uncomplete volume distribution.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

    include 'modules/header_user.php';
    include 'modules/permissionCheck.php';

    // Check permission
    if(!isMaintainer()) {
        header("Location: index.php");
        exit();
    }

    include 'modules/header.php';

    include 'modules/dataTable_BioManager.php';
?>
<script src="js/filterDataTable.js"></script>
<script src="js/dropdown.js"></script>
<script src="js/formatTableCellRight.js"></script>

<h1>Auswertung - Lieferscheine mit offener Mengenverteilung</h1>

<p>
    <?php if(isMaintainer()) {?><a href="addDeliveryNote.php">Lieferschein hinzufügen</a><?php } ?>
</p>

<?php
    if(isMaintainer() && isset($_GET['action']) && isset($_GET['id'])) {
        if($_GET['action'] == 'edit') {
            // Action - Edit a delivery note
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editDeliveryNote.php?id=' . $_GET['id'] . '");</script>';
        } elseif($_GET['action'] == 'volDist') {
            // Action - Edit volume distribution of a delivery note
            // Forwarding to edit page and add parameters
            echo '<script>window.location.replace("editCropVolumeDistribution.php?id=' . $_GET['id'] . '");</script>';
        }
    }
?>

<p>
    <input type="text" id="filterInput-tableDeliveryNote" onkeyup="filterData(&quot;tableDeliveryNote&quot;)" placeholder="Suchtext eingeben..." title="Suchtext"> 
</p>

<?php
    $conn = new Mysql();
    $conn -> dbConnect();
    $result = $conn -> select(
        'T_DeliveryNote LEFT JOIN T_Supplier ON T_Supplier.id = supplierId',
        'T_DeliveryNote.id, year, nr, amount, deliverDate, T_Supplier.name AS supplierName, COALESCE((SELECT SUM(amount) FROM T_CropVolumeDistribution WHERE deliveryNoteId = T_DeliveryNote.id), \'0\') AS calcAmount',
        'T_DeliveryNote.id NOT IN(SELECT DISTINCT deliveryNoteId FROM T_CropVolumeDistribution) '
        . 'OR amount <> (SELECT SUM(amount) FROM T_CropVolumeDistribution WHERE deliveryNoteId = T_DeliveryNote.id)',
        'year DESC, nr DESC');
/*
SELECT
	T_DeliveryNote.id, year, nr, amount, deliverDate, T_Supplier.name AS supplierName, COALESCE((SELECT SUM(amount) FROM T_CropVolumeDistribution WHERE deliveryNoteId = T_DeliveryNote.id), '0') AS calcAmount
FROM web234_db2.T_DeliveryNote
	LEFT JOIN T_Supplier ON T_Supplier.id = supplierId
WHERE T_DeliveryNote.id NOT IN(SELECT DISTINCT deliveryNoteId FROM T_CropVolumeDistribution)
	OR amount <> (SELECT SUM(amount) FROM T_CropVolumeDistribution WHERE deliveryNoteId = T_DeliveryNote.id)
ORDER BY year DESC, nr DESC
*/
    $conn -> dbDisconnect();
    $conn = NULL;

    if(isMaintainer()) {
        dataTable_BioManager::showWithDeliveryNoteActions(
            $result,
            'dataTable-tableDeliveryNote',
            array('year', 'nr', 'deliverDate', 'amount', 'calcAmount', 'supplierName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Mengenverteilung', 'Lieferant', 'Aktionen'));
    } else {
        dataTable_BioManager::show(
            $result,
            'dataTable-tableDeliveryNote',
            array('year', 'nr', 'deliverDate', 'amount', 'calcAmount', 'supplierName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Mengenverteilung', 'Lieferant'));
    }
?>
<script>    
    formatTableCellRight("dataTable-tableDeliveryNote", 1);
    formatTableCellRight("dataTable-tableDeliveryNote", 3);
    formatTableCellRight("dataTable-tableDeliveryNote", 4);
</script>
<?php
    include 'modules/footer.php';
?>