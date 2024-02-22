<?php

use App\Models\Plot;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;

// Required passed variables:
//  $index => Int
// Optional passed variables:
//  $selected => Id that should be selected
//  $supplierId => Filter the plots to the one belonging to given id

$query = Plot::getQueryBuilder()->orderBy('nr');
if (isset($supplierId)) {
    $query->where(ColType::Int, 'supplierId', Condition::Equal, $supplierId);
}

$plots = Plot::all($query);
?>
<select name="plot[<?= $index ?>]">
    <?php /** @var \App\Models\Plot $plot */
    foreach ($plots as $plot) {
        if ($plot->getIsLocked()) { continue; } ?>
        <option value="<?= $plot->getId() ?>" <?php
            if (isset($selected) && $plot->getId() === $selected) { ?>selected<?php } ?>
        ><?= $plot->getNr() ?> <?= $plot->getName() ?></option>
    <?php } ?>
</select>