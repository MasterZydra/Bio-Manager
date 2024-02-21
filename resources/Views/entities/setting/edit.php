<?php
/** @var \App\Models\Setting $setting */

use Framework\Authentication\Auth;
?>
<?= component('layout.header') ?>

<h1><?= __('EditSetting') ?></h1>

<p>
    <a href="/setting"><?= __('ShowAllSettings') ?></a>    
</p>

<form action="update" method="post">
    <input name="id" type="hidden" value="<?= $setting->getId() ?>">

    <label class="required"><?= __('Name') ?>:</label><br>
    <input id="name" type="text" size="100" maxlength="100" value="<?= $setting->getName() ?>" readonly><br>

    <label for="description" class="required"><?= __('Description') ?>:</label><br>
    <input id="description" name="description" type="text" size="255" maxlength="255" value="<?= $setting->getDescription() ?>" required><br>

    <label for="value" class="required"><?= __('Value') ?>:</label><br>
    <input id="value" name="value" type="text" size="255" maxlength="255" value="<?= $setting->getValue() ?>" required autofocus><br>

    <button><?= __('Save') ?></button>
</form>

<form action="destroy" method="post">
    <input name="id" type="hidden" value="<?= $setting->getId() ?>">
    <button class="red"><?= __('Delete') ?></button>
</form>

<?= component('layout.footer') ?>