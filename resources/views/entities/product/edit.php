<?= component('layout.header') ?>

<?php /** @var \App\Models\Product $product */ ?>

<form action="update" method="post">
    <input name="id" type="hidden" value="<?= $product->getId() ?>">

    <label for="name" class="required"><?= __('ProductName') ?>:</label><br>
    <input id="name" name="name" type="text" size="40" maxlength="50" value="<?= $product->getName() ?>" required autofocus><br>
    
    <label>
        <input type="hidden" name="isDiscontinued" value="0">
        <input type="checkbox" name="isDiscontinued" value="1"
            <?php
            if ($product->getIsDiscontinued()) {
                echo ' checked';
            }
            ?>>
        <?= __('IsDiscontinued') ?>
    </label><br>

    <button><?= __('Save') ?></button>
</form>

<form action="destroy" method="post">
    <input name="id" type="hidden" value="<?= $product->getId() ?>">
    <button><?= __('Delete') ?></button>
</form>

<?= component('layout.footer') ?>