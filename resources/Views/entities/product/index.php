<?= component('layout.header') ?>

<h1><?= __('Product') ?></h1>

<?php /** @var \App\Models\Product $product */
foreach ($products as $product): ?>
    <?= $product->getId() ?> - <?= $product->getName() ?> - <?= $product->getIsDiscontinued() ? 'true' : 'false' ?>
    <a href="product/show?id=<?= $product->getId() ?>">Details</a>
    <a href="product/edit?id=<?= $product->getId() ?>">Edit</a>
    <?= $product->getCreatedAt() ?> - <?= $product->getUpdatedAt() ?>
    <br>
<?php endforeach ?>

<button style="cursor: pointer" onclick="window.location.href='product/create'"><?= __('CreateNewProduct') ?></button>

<?= component('layout.footer') ?>