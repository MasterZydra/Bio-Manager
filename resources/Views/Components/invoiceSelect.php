<?php

use App\Models\Invoice;
use Framework\Database\Query\SortOrder;

// Optional passed variables:
//  $selected => Id that should be selected

$invoices = Invoice::all(Invoice::getQueryBuilder()
    ->orderBy('year', SortOrder::Desc)
    ->orderBy('nr', SortOrder::Desc)
);

?>
<label for="invoiceId"><?= __('Invoice') ?>:</label><br>
<select id="invoiceId" name="invoiceId">
    <option value=""><?= __('PleaseSelect') ?></option>
    <?php /** @var \App\Models\Invoice $invoice */
    foreach ($invoices as $invoice) { ?>
        <option value="<?= $invoice->getId() ?>" <?php
            if (isset($selected) && $invoice->getId() === $selected) { ?>selected<?php } ?>
        ><?= $invoice->getYear() ?> <?= $invoice->getNr() ?></option>
    <?php } ?>
</select>