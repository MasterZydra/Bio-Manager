<?php
    // Optional passed variables:
    //  $invoiceId => Current invoice id
    if (!isset($invoiceId)) {
        $invoiceId = null;
    }
?>
<label for="deliveryNotes" class="required"><?= __('DeliveryNotes') ?>:</label><br>
<?php 
    $index = 0;
    /** @var \App\Models\DeliveryNote $deliveryNote */
    foreach ($deliveryNotes as $deliveryNote) {
?>
    <label>
        <input type="hidden" name="deliveryNote[<?= $index ?>]" value="<?= $deliveryNote->getId() ?>-0">
        <input type="checkbox" name="deliveryNote[<?= $index ?>]" value="<?= $deliveryNote->getId() ?>-1"
            <?php
            if ($deliveryNote->getInvoiceId() === $invoiceId) {
                echo ' checked';
            }
            ?>>
        <?= $deliveryNote->getYear() ?> <?= $deliveryNote->getNr() ?>
    </label><br>
<?php $index++; } ?>