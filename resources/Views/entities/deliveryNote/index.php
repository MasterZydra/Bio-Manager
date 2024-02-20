<?php
    use Framework\Authentication\Auth;
    use Framework\Facades\Convert;
?>
<?= component('layout.header') ?>

<h1><?= __('DeliveryNote') ?></h1>

<p>
    <?php if (Auth::hasRole('Maintainer')) {
        ?><a href="deliveryNote/create"><?= __('AddDeliveryNote') ?></a><?php
    } ?>
</p>

<?= component('filterInput') ?>
<table id="dataTable" class="scrollable">
    <tr>
        <th class="center"><?= __('Year') ?></th>
        <th class="center"><?= __('No.') ?></th>
        <th class="center"><?= __('Date') ?></th>
        <th class="center"><?= __('Amount') ?> (<?= sprintf(__('inX'), setting('massUnit')) ?>)</th>
        <th class="center"><?= __('Supplier') ?></th>
        <th class="center"><?= __('Product') ?></th>
        <th class="center"><?= __('Recipient') ?></th>
        <th class="center"><?= __('Actions') ?></th>
    </tr>
    <?php /** @var \App\Models\DeliveryNote $deliveryNote */
    foreach ($deliveryNotes as $deliveryNote): ?>
    <tr>
        <td class="center"><?= $deliveryNote->getYear() ?></td>
        <td class="center"><?= $deliveryNote->getNr() ?></td>
        <td class="center"><?= $deliveryNote->getDeliveryDate() ?></td>
        <td class="right"><?= $deliveryNote->getAmount() ?></td>
        <td><?= $deliveryNote->getSupplier()->getName() ?></td>
        <td><?= $deliveryNote->getProduct()->getName() ?></td>
        <td><?= $deliveryNote->getRecipient()->getName() ?></td>
        <td>
            <a href="deliveryNote/edit?id=<?= $deliveryNote->getId() ?>"><?=__('Edit') ?></a>
            <a href="volumeDistribution/edit?id=<?= $deliveryNote->getId() ?>"><?=__('VolumeDistribution') ?></a>
        </td>
    </tr>
    <?php endforeach ?>
</table>

<?= component('layout.footer') ?>