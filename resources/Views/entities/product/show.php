<?= component('layout.header') ?>

<h1><?= __('Product') ?></h1>

<?php /** @var \App\Models\Product $product */ ?>
Id: <?= $product->getId() ?><br>
Name: <?= $product->getName() ?><br>
IsDiscontinued: <?= $product->getIsDiscontinued() ? 'true' : 'false' ?>

<?= component('layout.footer') ?>