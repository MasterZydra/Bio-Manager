<?php
    use Framework\Authentication\Auth;
    use Framework\Facades\Convert;
?>
<?= component('layout.header') ?>

<h1><?= __('Supplier') ?></h1>

<p>
    <?php if (Auth::hasRole('Maintainer')) {
        ?><a href="supplier/create"><?= __('AddSupplier') ?></a><?php
    } ?>
</p>

<?= component('filterInput') ?>

<table id="dataTable" class="scrollable">
    <tr>
        <th class="center"><?= __('Name') ?></th>
        <th class="center"><?= __('IsLocked') ?></th>
        <th class="center"><?= __('FullPayout') ?></th>
        <th class="center"><?= __('Actions') ?></th>
    </tr>
    <?php /** @var \App\Models\Supplier $supplier */
    foreach ($suppliers as $supplier): ?>
    <tr>
        <td><?= $supplier->getName() ?></td>
        <td class="center"><?= Convert::boolToTString($supplier->getIsLocked()) ?></td>
        <td class="center"><?= Convert::boolToTString($supplier->getHasFullPayout()) ?></td>
        <td><a href="supplier/edit?id=<?= $supplier->getId() ?>"><?=__('Edit') ?></a></td>
    </tr>
    <?php endforeach ?>
</table>

<?= component('layout.footer') ?>