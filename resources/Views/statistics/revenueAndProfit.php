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


<div style="margin-top: 20px; background-color: white;max-width: 1200px;">
    <canvas id="myChart"></canvas>
</div>

<script src="js/chart.umd.js"></script>

<script>
const ctx = document.getElementById('myChart');

const handleResize = (chart) => {
    chart.resize();
}

new Chart(ctx, {
    type: 'line',
    data: {
        datasets: [
            {
                label: '<?= __('Revenue') ?>',
                data: <?= json_encode(array_map(fn(array $line): float => $line['revenue'], $data)) ?>,
                borderWidth: 1
            },
            {
                label: '<?= __('Payouts') ?>',
                data: <?= json_encode(array_map(fn(array $line): float => $line['payouts'], $data)) ?>,
                borderWidth: 1
            },
            {
                label: '<?= __('Profit') ?>',
                data: <?= json_encode(array_map(fn(array $line): float => $line['profit'], $data)) ?>,
                borderWidth: 1
            },
        ]
    },
    options: {
        responsive: true,
        onResize: handleResize,
        maintainAspectRatio: true,
        scales: {
            x: {
                title: {
                    display: true,
                    text: '<?= __('Year') ?>',
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: '<?= __('inX', setting('currencyUnit')) ?>'
                }
            }
        }
    }
});
</script>

<?= component('layout.footer') ?>