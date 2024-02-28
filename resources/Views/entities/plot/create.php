<?= component('layout.header') ?>

<h1><?= __('AddPlot') ?></h1>

<p>
    <a href="/plot"><?= __('ShowAllPlots') ?></a>    
</p>

<form action="store" method="post">
    <label for="nr" class="required"><?= __('No.') ?>:</label><br>
    <input id="nr" name="nr" type="text" required autofocus><br>
    
    <label for="name" class="required"><?= __('Name') ?>:</label><br>
    <input id="name" name="name" type="text" required><br>
    
    <label for="subdistrict" class="required"><?= __('Subdistrict') ?>:</label><br>
    <input id="subdistrict" name="subdistrict" type="text" list="subdistricts" autocomplete="off" required><br>    
    <?= component('datalistSubdistricts') ?>

    <?= component('supplierSelect') ?><br>
    
    <button><?= __('Create') ?></button>
</form>

<?= component('layout.footer') ?>