<?php /** @var \App\Models\Supplier $supplier */ ?>
<?= component('layout.header') ?>

<h1><?= __('EditSupplier') ?></h1>

<p>
    <a href="/supplier"><?= __('ShowAllSuppliers') ?></a>    
</p>

<form action="update" method="post">
    <input name="id" type="hidden" value="<?= $supplier->getId() ?>">

    <label for="name" class="required"><?= __('Name') ?>:</label><br>
    <input id="name" name="name" type="text" size="40" maxlength="50" value="<?= $supplier->getName() ?>" required autofocus><br>
    
    <label>
        <input type="hidden" name="isLocked" value="0">
        <input type="checkbox" name="isLocked" value="1"
            <?php
            if ($supplier->getIsLocked()) {
                echo ' checked';
            }
            ?>>
        <?= __('IsLocked') ?>
    </label><br>

    <button><?= __('Save') ?></button>
</form>

<form action="destroy" method="post">
    <input name="id" type="hidden" value="<?= $supplier->getId() ?>">
    <button class="red"><?= __('Delete') ?></button>
</form>

<?= component('layout.footer') ?>