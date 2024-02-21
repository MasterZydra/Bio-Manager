<?php

use Framework\Database\Database;
use Framework\Database\Query\SortOrder;
use Framework\Database\QueryBuilder;

// Optional passed variables:
//  $selected => Id that should be selected

$dataSet = Database::executeBuilder(QueryBuilder::new('invoices')->select('DISTINCT year')->orderBy('year', SortOrder::Desc));

$years = [];
if ($dataSet !== false) {
    while ($row = $dataSet->fetch_assoc()) {
        $years[] = $row['year'];
    }
}

?>
<label for="invoiceYear"><?= __('InvoiceYear') ?>:</label><br>
<select id="invoiceYear" name="invoiceYear">
    <option value=""><?= __('PleaseSelect') ?></option>
    <?php foreach ($years as $year) { ?>
        <option value="<?= $year ?>" <?php
            if (isset($selected) && $year === $selected) { ?>selected<?php } ?>
        ><?= $year ?></option>
    <?php } ?>
</select>