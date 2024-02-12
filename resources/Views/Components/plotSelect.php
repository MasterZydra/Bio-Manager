<?php
    use App\Models\Plot;
    // Required passed variables:
    //  $index => Int
    // Optional passed variables:
    //  $selected => Id that should be selected
?>
<select name="plot[<?= $index ?>]">
    <?php /** @var \App\Models\Plot $plot */
    foreach (Plot::all() as $plot) { 
        if ($plot->getIsLocked()) { continue; } ?>
        <option value="<?= $plot->getId() ?>" <?php
            if (isset($selected) && $plot->getId() === $selected) { ?>selected<?php } ?>
        ><?= $plot->getNr() ?> <?= $plot->getName() ?></option>
    <?php } ?>
</select>