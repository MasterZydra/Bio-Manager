<?php /** @var \App\Models\Price $price */ ?>
<?= component('layout.header') ?>

<h1><?= __('EditPrice') ?></h1>

<p>
    <a href="/price"><?= __('ShowAllPrices') ?></a>    
</p>

<form action="update" method="post">
    <input name="id" type="hidden" value="<?= $price->getId() ?>">

    <label for="year" class="required"><?= __('Year') ?>:</label><br>
    <input id="year" name="year" type="number" value="<?= $price->getYear() ?>" required autofocus><br>

    <?= component('productSelect', ['selected' => $price->getProductId()]) ?><br>

    <?= component('recipientSelect', ['selected' => $price->getRecipientId()]) ?><br>

    <!-- Preis (pro getSetting('massUnit');) -->
    <label for="price" class="required"><?= __('Price') ?> (<?= __('XPerY', setting('currencyUnit'), setting('massUnit')) ?>):</label><br>
    <input id="price" name="price" type="number" step="0.01" value="<?= $price->getPrice() ?>" required><br>
    
    <!-- Preis (pro getSetting('massUnit');) -->
    <label for="pricePayout" class="required"><?= __('Payout') ?> (<?= __('XPerY', setting('currencyUnit'), setting('massUnit')) ?>):</label><br>
    <input id="pricePayout" name="pricePayout" type="number" step="0.01" value="<?= $price->getPricePayout() ?>" required><br>

    <button><?= __('Save') ?></button>
</form>

<?php if ($price->allowDelete()) { ?>
<form action="destroy" method="post">
    <input name="id" type="hidden" value="<?= $price->getId() ?>">
    <button class="red"><?= __('Delete') ?></button>
</form>
<?php } ?>

<?= component('layout.footer') ?>