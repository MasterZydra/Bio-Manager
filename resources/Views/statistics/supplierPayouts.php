<?= component('layout.header') ?>

<h1><?= __('ShowPayouts') ?></h1>

<form method="post">
    <?= component('invoiceSelect') ?><br>

    <button><?= __('Show') ?></button><br><br>

    <?= __('Or') ?><br><br>

    <?= component('invoiceYearSelect') ?><br>

    <button><?= __('Show') ?></button>
</form>

<?= component('layout.footer') ?>