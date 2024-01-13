<?php
    use Framework\Authentication\Auth;
    use Framework\Facades\Convert;
?>
<?= component('layout.header') ?>

<h1><?= __('Product') ?></h1>

<p>
    <?php if (Auth::hasRole('Maintainer')) {
        ?><a href="product/create"><?= __('AddProduct') ?></a><?php
    } ?>
</p>

<?= component('filterInput') ?>

<table id="dataTable">
    <tr>
        <th class="center"><?= __('ProductName') ?></th>
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