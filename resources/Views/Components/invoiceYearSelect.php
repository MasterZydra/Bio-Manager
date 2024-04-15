<?php

use Framework\Database\Database;
use Framework\Database\Query\SortOrder;
use Framework\Database\QueryBuilder;

// Optional passed variables:
//  $selected => Id that should be selected
//  $notEmpty => Do not show the "Please select" entry

$dataSet = Database::executeBuilder(QueryBuilder::new('invoices')->select('DISTINCT year')->orderBy('year', SortOrder::Desc));

$years = [];
if ($dataSet !== false) {
    while ($row = $dataSet->fetch()) {
        $years[] = $row['year'];
    }
}

?>
<label for="invoiceYear"><?= __('InvoiceYear') ?>:</label><br>
<select id="invoiceYear" name="invoiceYear">
    <?php if (!isset($notEmpty)) { ?>
        <option value=""><?= __('PleaseSelect') ?></option>
    <?php } ?>
    <?php foreach ($years as $year) { ?>
        <option value="<?= $year ?>" <?php
            if (isset($selected) && $year === $selected) { ?>selected<?php } ?>
        ><?= $year ?></option>
    <?php } ?>
</select>