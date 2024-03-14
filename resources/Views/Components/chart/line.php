<?php
/** @var string $chartName */
/** @var string $xTitle */
/** @var string $yTitle */
/** @var array $dataSet */ // ['label' => 'string', 'data' => [array]]
?>
<?= component('chart.chartJs', once: true) ?>

<div style="margin-top: 20px; background-color: white;max-width: 1200px;">
    <canvas id="<?= $chartName ?>"></canvas>
</div>

<script>
const ctx<?= $chartName ?> = document.getElementById('<?= $chartName ?>');

const handleResize<?= $chartName ?> = (chart) => {
    chart.resize();
}

new Chart(ctx<?= $chartName ?>, {
    type: 'line',
    data: {
        datasets: [
            <?php foreach ($dataSet as $data) { ?>
            {
                label: '<?= $data['label'] ?>',
                data: <?= json_encode($data['data']) ?>,
                borderWidth: 1
            },
            <?php } ?>
        ]
    },
    options: {
        responsive: true,
        onResize: handleResize<?= $chartName ?>,
        maintainAspectRatio: true,
        scales: {
            x: {
                title: {
                    display: true,
                    text: '<?= $xTitle ?>',
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: '<?= $yTitle ?>'
                }
            }
        }
    }
});
</script>