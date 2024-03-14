<?php use Framework\Facades\Format; ?>
<?= component('layout.header') ?>

<h1><?= __('AmountDevelopment') ?></h1>

<table class="scrollable">
    <tr>
        <th class="center"><?= __('Year') ?></th>
        <th class="center"><?= __('Amount') ?></th>
    </tr>
    <?php foreach ($data as $year => $amount): ?>
    <tr>
        <td class="center"><?= $year ?></td>
        <td class="center"><?= Format::decimal($amount) ?></td>
    </tr>
    <?php endforeach ?>
</table>

<?= component('chart.line', [
    'chartName' => 'amountDevelopment',
    'xTitle' => __('Year'),
    'yTitle' => __('inX', setting('massUnit')),
    'dataSet' => [['label' => __('Amount'), 'data' => $data]],
]) ?>

<?= component('layout.footer') ?>