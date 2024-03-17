<?php use Framework\Facades\Format; ?>
<?= component('layout.header') ?>

<h1><?= __('PriceDevelopment') ?></h1>

<table class="scrollable">
    <tr>
        <th class="center"><?= __('Product') ?></th>
        <th class="center"><?= __('Year') ?></th>
        <th class="center"><?= __('Price') ?> (<?= __('XPerY', setting('currencyUnit'), setting('massUnit')) ?>)</th>
        <th class="center"><?= __('Payout') ?> (<?= __('XPerY', setting('currencyUnit'), setting('massUnit')) ?>)</th>
    </tr>
    <?php foreach ($dataPrice as $product => $prices): ?>
        <?php foreach ($prices as $year => $price): ?>
        <tr>
            <td><?= $product ?></td>
            <td class="center"><?= $year ?></td>
            <td class="center"><?= Format::currency($price) ?></td>
            <td class="center"><?= Format::currency($dataPricePayout[$product][$year]) ?></td>
        </tr>
        <?php endforeach ?>
    <?php endforeach ?>
</table>

<?php
    $chartCount = 0;
    foreach (array_keys($dataPrice) as $product) {
        ?><h3><?= $product ?></h3><?php
        component('chart.line', [
            'chartName' => 'priceDevelopment' . $chartCount,
            'xTitle' => __('Year'),
            'yTitle' => __('XPerY', setting('currencyUnit'), setting('massUnit')),
            'dataSet' => [
                ['label' => __('Price'), 'data' => $dataPrice[$product]],
                ['label' => __('Payout'), 'data' => $dataPricePayout[$product]],
            ],
        ]);
        $chartCount += 1;
    }
?>

<?= component('layout.footer') ?>