<?php use Framework\Facades\Format; ?>
<?= component('layout.header') ?>

<h1><?= __('OpenVolumeDistributions') ?></h1>

<?= component('filterInput') ?>
<table id="dataTable" class="scrollable">
    <tr>
        <th class="center"><?= __('Year') ?></th>
        <th class="center"><?= __('No.') ?></th>
        <th class="center"><?= __('Date') ?></th>
        <th class="center"><?= __('Amount') ?> (<?= __('inX', setting('massUnit')) ?>)</th>
        <th class="center"><?= __('AmountInVolumeDistribution') ?> (<?= __('inX', setting('massUnit')) ?>)</th>
        <th class="center"><?= __('Actions') ?></th>
    </tr>
    <?php /** @var \App\Models\DeliveryNote $deliveryNote */
    foreach ($deliveryNotes as $deliveryNote): ?>
    <tr>
        <td class="center"><?= $deliveryNote->getYear() ?></td>
        <td class="center"><?= $deliveryNote->getNr() ?></td>
        <td class="center"><?= Format::date($deliveryNote->getDeliveryDate()) ?></td>
        <td class="right"><?= $deliveryNote->getAmount() ?></td>
        <td class="right"><?= $deliveryNote->getCalcSum() ?></td>
        <td>
            <a href="deliveryNote/edit?id=<?= $deliveryNote->getId() ?>"><?=__('Edit') ?></a>
            <a href="volumeDistribution/edit?id=<?= $deliveryNote->getId() ?>"><?=__('VolumeDistribution') ?></a>
        </td>
    </tr>
    <?php endforeach ?>
</table>

<?= component('layout.footer') ?>