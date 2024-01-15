<?php
    use App\Models\Product;
    // Optional passed variables:
    //  $selected => Id that should be selected
?>
<label for="product" class="required"><?= __('Product') ?>:</label><br>
<select id="product" name="product">
    <?php /** @var \App\Models\Product $product */
    foreach (Product::all() as $product) { 
        if ($product->getIsDiscontinued()) { continue; } ?>
        <option value="<?= $product->getId() ?>" <?php
            if (isset($selected) && $product->getId() === $selected) { ?>selected<?php } ?>
        ><?= $product->getName() ?></option>
    <?php } ?>
</select>