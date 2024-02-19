<?= component('layout.header') ?>

<h1><?= __('EditImprint') ?></h1>

<form method="post">
    <h2><?= __('Provider') ?></h2>

    <label for="imprintProviderName" class="required"><?= __('Name') ?>:</label><br>
    <input id="imprintProviderName" name="imprintProviderName" type="text" value="<?= setting('imprintProviderName') ?>" autofocus required><br>

    <label for="imprintProviderStreet" class="required"><?= __('Street') ?>:</label><br>
    <input id="imprintProviderStreet" name="imprintProviderStreet" type="text" value="<?= setting('imprintProviderStreet') ?>" required><br>

    <label for="imprintProviderPostalCode" class="required"><?= __('PostalCode') ?>:</label><br>
    <input id="imprintProviderPostalCode" name="imprintProviderPostalCode" type="text" value="<?= setting('imprintProviderPostalCode') ?>" required><br>

    <label for="imprintProviderCity" class="required"><?= __('City') ?>:</label><br>
    <input id="imprintProviderCity" name="imprintProviderCity" type="text" value="<?= setting('imprintProviderCity') ?>" required><br>

    <label for="imprintProviderEmail" class="required"><?= __('Email') ?>:</label><br>
    <input id="imprintProviderEmail" name="imprintProviderEmail" type="text" value="<?= setting('imprintProviderEmail') ?>" required><br>

    <h2><?= __('Responsible') ?></h2>

    <label for="imprintResponsibleName" class="required"><?= __('Name') ?>:</label><br>
    <input id="imprintResponsibleName" name="imprintResponsibleName" type="text" value="<?= setting('imprintResponsibleName') ?>" required><br>

    <label for="imprintResponsibleStreet" class="required"><?= __('Street') ?>:</label><br>
    <input id="imprintResponsibleStreet" name="imprintResponsibleStreet" type="text" value="<?= setting('imprintResponsibleStreet') ?>" required><br>

    <label for="imprintResponsiblePostalCode" class="required"><?= __('PostalCode') ?>:</label><br>
    <input id="imprintResponsiblePostalCode" name="imprintResponsiblePostalCode" type="text" value="<?= setting('imprintResponsiblePostalCode') ?>" required><br>

    <label for="imprintResponsibleCity" class="required"><?= __('City') ?>:</label><br>
    <input id="imprintResponsibleCity" name="imprintResponsibleCity" type="text" value="<?= setting('imprintResponsibleCity') ?>" required><br>

    <label for="imprintResponsibleEmail" class="required"><?= __('Email') ?>:</label><br>
    <input id="imprintResponsibleEmail" name="imprintResponsibleEmail" type="text" value="<?= setting('imprintResponsibleEmail') ?>" required><br>

    <button><?= __('Save') ?></button>
</form>

<?= component('layout.footer') ?>