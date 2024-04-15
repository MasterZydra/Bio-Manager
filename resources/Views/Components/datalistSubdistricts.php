<?php

use Framework\Database\Database;
use Framework\Database\QueryBuilder;

$dataSet = Database::executeBuilder(QueryBuilder::new('plots')->select('DISTINCT subdistrict')->orderBy('subdistrict'));

$subdistricts = [];
if ($dataSet !== false) {
    while ($row = $dataSet->fetch()) {
        $subdistricts[] = $row['subdistrict'];
    }
}

?>

<datalist id="subdistricts">
    <?php foreach ($subdistricts as $subdistrict) { ?>
        <option value="<?= $subdistrict ?>"><?= $subdistrict ?></option>
    <?php } ?>
</datalist>