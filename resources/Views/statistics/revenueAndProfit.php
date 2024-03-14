<?php use Framework\Facades\Format; ?>
<?= component('layout.header') ?>

<h1><?= __('RevenueAndProfit') ?></h1>

<table class="scrollable">
    <tr>
        <th class="center"><?= __('Year') ?></th>
        <th class="center"><?= __('Revenue') ?></th>
        <th class="center"><?= __('Payouts') ?></th>
        <th class="center"><?= __('Profit') ?></th>
    </tr>
    <?php foreach ($data as $year => $line): ?>
    <tr>
        <td class="center"><?= $year ?></td>
        <td class="center"><?= Format::currency($line['revenue']) ?></td>
        <td class="center"><?= Format::currency($line['payouts']) ?></td>
        <td class="center"><?= Format::currency($line['profit']) ?></td>
    </tr>
    <?php endforeach ?>
</table>

<?= component('chart.line', [
    'chartName' => 'revenueAndProfit',
    'xTitle' => __('Year'),
    'yTitle' => __('inX', setting('currencyUnit')),
    'dataSet' => [
        ['label' => __('Revenue'), 'data' => array_map(fn(array $line): float => $line['revenue'], $data)],
        ['label' => __('Payouts'), 'data' => array_map(fn(array $line): float => $line['payouts'], $data)],
        ['label' => __('Profit'), 'data' => array_map(fn(array $line): float => $line['profit'], $data)],
    ]
]) ?>

<?= component('layout.footer') ?>