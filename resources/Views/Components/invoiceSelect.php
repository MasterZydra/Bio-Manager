<?php

use App\Models\Invoice;

// Optional passed variables:
//  $selected => Id that should be selected

?>
<label for="invoiceId"><?= __('Invoice') ?>:</label><br>
<select id="invoiceId" name="invoiceId">
    <option value=""><?= __('PleaseSelect') ?></option>
    <?php /** @var \App\Models\Invoice $invoice */
    foreach (Invoice::all() as $invoice) { ?>
        <option value="<?= $invoice->getId() ?>" <?php
            if (isset($selected) && $invoice->getId() === $selected) { ?>selected<?php } ?>
        ><?= $invoice->getYear() ?> <?= $invoice->getNr() ?></option>
    <?php } ?>
</select>