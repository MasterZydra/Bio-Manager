<?php /** @var \App\Models\Product $product */ ?>
<?= component('layout.header') ?>

<h1><?= __('EditProduct') ?></h1>

<p>
    <a href="/product"><?= __('ShowAllProducts') ?></a>    
</p>

<form action="update" method="post">
    <input name="id" type="hidden" value="<?= $product->getId() ?>">

    <label for="name" class="required"><?= __('Name') ?>:</label><br>
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
    <button class="red"><?= __('Delete') ?></button>
</form>

<?= component('layout.footer') ?>