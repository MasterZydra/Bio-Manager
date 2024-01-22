<?php /** @var \App\Models\plot $plot */ ?>
<?= component('layout.header') ?>

<h1><?= __('EditPlot') ?></h1>

<p>
    <a href="/plot"><?= __('ShowAllPlots') ?></a>    
</p>

<form action="update" method="post">
    <input name="id" type="hidden" value="<?= $plot->getId() ?>">

    <label for="nr" class="required"><?= __('No.') ?>:</label><br>
    <input id="nr" name="nr" type="text" value="<?= $plot->getNr() ?>" required autofocus><br>
    
    <label for="name" class="required"><?= __('Name') ?>:</label><br>
    <input id="name" name="name" type="text" value="<?= $plot->getName() ?>" required><br>
    
    <label for="subdistrict" class="required"><?= __('Subdistrict') ?>:</label><br>
    <input id="subdistrict" name="subdistrict" type="text" value="<?= $plot->getSubdistrict() ?>" required><br>
    
    <?= component('supplierSelect', ['selected' => $plot->getSupplierId()]) ?><br>
    
    <label>
        <input type="hidden" name="isLocked" value="0">
        <input type="checkbox" name="isLocked" value="1"
            <?php
            if ($plot->getIsLocked()) {
                echo ' checked';
            }
            ?>>
        <?= __('IsLocked') ?>
    </label><br>

    <button><?= __('Save') ?></button>
</form>

<form action="destroy" method="post">
    <input name="id" type="hidden" value="<?= $plot->getId() ?>">
    <button class="red"><?= __('Delete') ?></button>
</form>

<?= component('layout.footer') ?>