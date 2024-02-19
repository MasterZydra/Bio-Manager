<?php
    use App\Models\Supplier;
    // Optional passed variables:
    //  $selected => Id that should be selected
?>
<label for="supplierId" class="required"><?= __('Supplier') ?>:</label><br>
<select id="supplierId" name="supplierId">
    <?php /** @var \App\Models\Supplier $supplier */
    foreach (Supplier::all() as $supplier) { 
        if ($supplier->getIsLocked()) { continue; } ?>
        <option value="<?= $supplier->getId() ?>" <?php
            if (isset($selected) && $supplier->getId() === $selected) { ?>selected<?php } ?>
        ><?= $supplier->getName() ?></option>
    <?php } ?>
</select>