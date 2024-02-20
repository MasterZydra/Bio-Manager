<?php
    use \App\Models\Invoice;

    /** @var \App\Models\DeliveryNote $deliveryNote */
?>
<?= component('layout.header') ?>

<h1><?= __('EditDeliveryNote') ?></h1>

<p>
    <a href="/deliveryNote"><?= __('ShowAllDeliveryNotes') ?></a>    
</p>

<form action="update" method="post">
    <input name="id" type="hidden" value="<?= $deliveryNote->getId() ?>">

    <label for="year"><?= __('Year') ?>:</label><br>
    <input id="year" name="year" type="number" value="<?= $deliveryNote->getYear() ?>" readonly><br>

    <label for="nr"><?= __('No.') ?>:</label><br>
    <input id="nr" name="nr" type="number" value="<?= $deliveryNote->getNr() ?>" readonly><br>

    <label for="deliveryDate" class="required"><?= __('Date') ?>:</label><br>
    <input id="deliveryDate" name="deliveryDate" type="date" value="<?= $deliveryNote->getdeliveryDate() ?>" required autofocus><br>

    <label for="amount" class="required"><?= __('Amount') ?> (<?= sprintf(__('InX'), setting('massUnit')) ?>):</label><br>
    <input id="amount" name="amount" type="number" step="0.01" value="<?= $deliveryNote->getAmount() ?>" required><br>


    <?= component('productSelect', ['selected' => $deliveryNote->getProductId()]) ?><br>

    <?= component('supplierSelect', ['selected' => $deliveryNote->getSupplierId()]) ?><br>

    <?= component('recipientSelect', ['selected' => $deliveryNote->getRecipientId()]) ?><br>

    <label>
        <input type="hidden" name="isInvoiceReady" value="0">
        <input type="checkbox" name="isInvoiceReady" value="1"
            <?php
            if ($deliveryNote->getIsInvoiceReady()) {
                echo ' checked';
            }
            ?>>
        <?= __('ReadyForInvoice') ?>
    </label><br>

    <?php if ($deliveryNote->getInvoiceId() !== null) {
        $invoice = Invoice::findById($deliveryNote->getInvoiceId());
    ?>
    <label><?= __('Invoice') ?>:</label>
    <a href="/invoice/edit?id=<?= $deliveryNote->getInvoiceId() ?>">
        <?= $invoice->getYear() ?> <?= $invoice->getNr() ?>
    </a><br>
    <?php } ?>

    <button><?= __('Save') ?></button>
</form>

<form action="destroy" method="post">
    <input name="id" type="hidden" value="<?= $deliveryNote->getId() ?>">
    <button class="red"><?= __('Delete') ?></button>
</form>

<?= component('layout.footer') ?>