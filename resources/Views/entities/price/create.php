<?= component('layout.header') ?>

<h1><?= __('AddPrice') ?></h1>

<p>
    <a href="/price"><?= __('ShowAllPrices') ?></a>    
</p>

<form action="store" method="post">
    <label for="year" class="required"><?= __('Year') ?>:</label><br>
    <input id="year" name="year" type="number" value="<?= date("Y") ?>" required autofocus><br>

    <?= component('productSelect') ?><br>

    <?= component('recipientSelect') ?><br>

    <label for="price" class="required"><?= __('Price') ?> (<?= __('XPerY', setting('currencyUnit'), setting('massUnit')) ?>):</label><br>
    <input id="price" name="price" type="number" step="0.01" required><br>
    
    <label for="pricePayout" class="required"><?= __('Payout') ?> (<?= __('XPerY', setting('currencyUnit'), setting('massUnit')) ?>):</label><br>
    <input id="pricePayout" name="pricePayout" type="number" step="0.01" required><br>

    <button><?= __('Create') ?></button>
</form>

<?= component('layout.footer') ?>