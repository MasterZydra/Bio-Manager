<?php
/*
* deliveryNote.php
* ----------------
* This page shows all entries in the delivery note table.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

    include 'templates/overviewForm.php';

    $form = new overviewForm();
    // Common properties
    // -----------------
    $form -> heading            = "Lieferschein";

    $form -> accessPermission   = "(isMaintainer() || isInspector())";
    $form -> returnPage         = "deliveryNote.php";

    $form -> linkPermission     = "isMaintainer()";
    $form -> linkElement        = '<a href="addDeliveryNote.php">Lieferschein hinzufügen</a>';

    // Delete form properties
    // ----------------------
    $form -> tablePermission    = "isMaintainer()";
    $form -> restrictedTable    =
        "dataTable_BioManager::showWithDeliveryNoteDefaultActions(
            \$result,
            'dataTable-data',
            array('year', 'nr', 'deliverDate', 'amount', 'supplierName', 'productName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Lieferant', 'Produkt', 'Aktionen'));";
    $form -> defaultTable       =
        "dataTable_BioManager::show(
            \$result,
            'dataTable-data',
            array('year', 'nr', 'deliverDate', 'amount', 'supplierName', 'productName'),
            array('Jahr', 'Nr', 'Lieferdatum', 'Menge', 'Lieferant', 'Produkt'));";

     $form -> resultDataSet     =
         "\$conn -> select(
            'T_DeliveryNote '
          . 'LEFT JOIN T_Supplier ON T_Supplier.id = supplierId '
          . 'LEFT JOIN T_Product ON T_Product.id = productId',
            'T_DeliveryNote.id, year, nr, amount, deliverDate, T_Supplier.name AS supplierName, T_Product.name AS productName',
            NULL,
            'year DESC, nr DESC');";

    $form -> alignRightColumns  = array(1, 3);

    $form -> forwardingLogic    =
        "if(isMaintainer() && isset(\$_GET['action']) && isset(\$_GET['id'])) {
            if(\$_GET['action'] == 'delete') {
                // Action - Delete supplier
                echo '<script>window.location.replace(\"deleteDeliveryNote.php?id=' . \$_GET['id'] . '\");</script>';
            } elseif(\$_GET['action'] == 'edit') {
                // Action - Edit a delivery note
                // Forwarding to edit page and add parameters
                echo '<script>window.location.replace(\"editDeliveryNote.php?id=' . \$_GET['id'] . '\");</script>';
            } elseif(\$_GET['action'] == 'volDist') {
                // Action - Edit volume distribution of a delivery note
                // Forwarding to edit page and add parameters
                echo '<script>window.location.replace(\"editCropVolumeDistribution.php?id=' . \$_GET['id'] . '\");</script>';
            }
        }";

    $form -> show();
?>