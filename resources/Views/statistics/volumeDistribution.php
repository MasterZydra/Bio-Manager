<?= component('layout.header') ?>

<h1><?= __('ShowVolumeDistribution') ?></h1>

<form method="post">
    <?= component('invoiceYearSelect', ['notEmpty' => '']) ?><br>

    <button><?= __('Show') ?></button>
</form>

<?= component('layout.footer') ?>