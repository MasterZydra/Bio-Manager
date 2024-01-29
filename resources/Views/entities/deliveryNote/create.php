<?= component('layout.header') ?>

<h1><?= __('AddDeliveryNote') ?></h1>

<p>
    <a href="/deliveryNote"><?= __('ShowAllDeliveryNotes') ?></a>    
</p>

<form action="store" method="post">
    <label for="year" class="required"><?= __('Year') ?>:</label><br>
    <input id="year" name="year" type="number" value="<?= date("Y") ?>" required autofocus><br>

    <?= component('productSelect') ?><br>

    <?= component('supplierSelect') ?><br>

    <?= component('recipientSelect') ?><br>

    <button><?= __('Create') ?></button>
</form>

<?= component('layout.footer') ?>