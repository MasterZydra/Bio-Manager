<?php use Framework\Authentication\Session; ?>
<?= component('layout.header') ?>

<h1><?= __('DeveloperTools') ?></h1>

<form method="post">
    <label>
        <input type="hidden" name="showErrorMessages" value="0">
        <input type="checkbox" name="showErrorMessages" value="1"
            <?php if (Session::getValue('showErrorMessages') === 'true') {
                echo ' checked';
            } ?>>
        <?= __('ShowErrorMessages') ?>
    </label><br>

    <label>
        <input type="hidden" name="showSqlQueries" value="0">
        <input type="checkbox" name="showSqlQueries" value="1"
            <?php if (Session::getValue('showSqlQueries') === 'true') {
                echo ' checked';
            } ?>>
        <?= __('ShowSqlQueries') ?>
    </label><br>

    <button><?= __('Save') ?></button>
</form>

<?= component('layout.footer') ?>