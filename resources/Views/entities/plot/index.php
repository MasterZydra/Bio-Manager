<?php
    use Framework\Authentication\Auth;
    use Framework\Facades\Convert;
?>
<?= component('layout.header') ?>

<h1><?= __('Plot') ?></h1>

<p>
    <?php if (Auth::hasRole('Maintainer')) { ?>
        <a href="plot/create"><?= __('AddPlot') ?></a>
    <?php } ?>
</p>

<?= component('filterInput') ?>

<table id="dataTable" class="scrollable">
    <tr>
        <th class="center"><?= __('Nr') ?></th>
        <th class="center"><?= __('Name') ?></th>
        <th class="center"><?= __('Subdistrict') ?></th>
        <th class="center"><?= __('Supplier') ?></th>
        <th class="center"><?= __('IsLocked') ?></th>
        <th class="center"><?= __('Actions') ?></th>
    </tr>
    <?php /** @var \App\Models\Plot $plot */
    foreach ($plots as $plot): ?>
    <tr>
        <td><?= $plot->getNr() ?></td>
        <td><?= $plot->getName() ?></td>
        <td><?= $plot->getSubdistrict() ?></td>
        <td><?= $plot->getSupplier()->getName() ?></td>
        <td class="center"><?= Convert::boolToTString($plot->getIsLocked()) ?></td>
        <td><a href="plot/edit?id=<?= $plot->getId() ?>"><?=__('Edit') ?></a></td>
    </tr>
    <?php endforeach ?>
</table>

<?= component('layout.footer') ?>