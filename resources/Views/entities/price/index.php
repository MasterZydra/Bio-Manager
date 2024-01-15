<?php
    use Framework\Authentication\Auth;
    use Framework\Facades\Convert;
?>
<?= component('layout.header') ?>

<h1><?= __('Price') ?></h1>

<p>
    <?php if (Auth::hasRole('Maintainer')) {
        ?><a href="price/create"><?= __('AddPrice') ?></a><?php
    } ?>
</p>

<?= component('filterInput') ?>

<table id="dataTable">
    <tr>
        <th class="center"><?= __('Product') ?></th>
        <th class="center"><?= __('Recipient') ?></th>
        <th class="center"><?= __('Year') ?></th>
        <th class="center"><?= __('Price') ?></th>
        <th class="center"><?= __('Payout') ?></th>
        <th class="center"><?= __('Actions') ?></th>
    </tr>
    <?php /** @var \App\Models\Price $price */
    foreach ($prices as $price): ?>
    <tr>
        <td><?= $price->getProduct()->getName() ?></td>
        <td><?= $price->getRecipient()->getName() ?></td>
        <td class="center"><?= $price->getYear() ?></td>
        <td class="right"><?= number_format($price->getPrice(), 2, ',', '.') . ' €' ?></td>
        <td class="right"><?= number_format($price->getPricePayout(), 2, ',', '.') . ' €' ?></td>
        <td><a href="price/edit?id=<?= $price->getId() ?>"><?=__('Edit') ?></a></td>
    </tr>
    <?php endforeach ?>
</table>

<?= component('layout.footer') ?>