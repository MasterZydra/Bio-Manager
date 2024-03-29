<?php
    use Framework\Authentication\Auth;
    use Framework\Facades\Convert;
?>
<?= component('layout.header') ?>

<h1><?= __('Product') ?></h1>

<p>
    <a href="product/create"><?= __('AddProduct') ?></a>
</p>

<?= component('filterInput') ?>

<table id="dataTable" class="scrollable">
    <tr>
        <th class="center"><?= __('Name') ?></th>
        <th class="center"><?= __('IsDiscontinued') ?></th>
        <th class="center"><?= __('Actions') ?></th>
    </tr>
    <?php /** @var \App\Models\Product $product */
    foreach ($products as $product): ?>
    <tr>
        <td><?= $product->getName() ?></td>
        <td class="center"><?= Convert::boolToTString($product->getIsDiscontinued()) ?></td>
        <td><a href="product/edit?id=<?= $product->getId() ?>"><?=__('Edit') ?></a></td>
    </tr>
    <?php endforeach ?>
</table>

<?= component('layout.footer') ?>