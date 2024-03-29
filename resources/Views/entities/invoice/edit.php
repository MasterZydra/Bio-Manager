<?php
use \App\Models\DeliveryNote;

/** @var \App\Models\Invoice $invoice */
?>
<?= component('layout.header') ?>

<h1><?= __('EditInvoice') ?></h1>

<p>
    <a href="/invoice"><?= __('ShowAllInvoices') ?></a>    
</p>

<?php if (!$invoice->allowEdit()) { ?>
    <div class="message warning"><?= __('EntityCannotBeEdited') ?></div>
<?php } ?>

<form <?php if ($invoice->allowEdit()) { ?>action="update" method="post"<?php } ?>>
    <input name="id" type="hidden" value="<?= $invoice->getId() ?>">

    <label for="year"><?= __('Year') ?>:</label><br>
    <input id="year" name="year" type="number" value="<?= $invoice->getYear() ?>" readonly><br>

    <label for="nr"><?= __('No.') ?>:</label><br>
    <input id="nr" name="nr" type="number" value="<?= $invoice->getNr() ?>" readonly><br>

    <label for="invoiceDate" class="required"><?= __('Date') ?>:</label><br>
    <input id="invoiceDate" name="invoiceDate" type="date" value="<?= $invoice->getInvoiceDate() ?>" required autofocus><br>
    
    <?= component('recipientSelect', ['selected' => $invoice->getRecipientId()]) ?><br>

    <label>
        <input type="hidden" name="isPaid" value="0">
        <input type="checkbox" name="isPaid" value="1"
            <?php
            if ($invoice->getIsPaid()) {
                echo ' checked';
            }
            ?>>
        <?= __('IsPaid') ?>
    </label><br>

    <?= component('deliveryNoteList', [
        'deliveryNotes' => DeliveryNote::allReadyForInvoice($invoice),
        'invoiceId' => $invoice->getId(),
    ]) ?><br>

    <?php if ($invoice->allowEdit()) { ?>
    <button><?= __('Save') ?></button>
    <?php } ?>
</form>

<?php if ($invoice->allowDelete() && $invoice->allowEdit()) { ?>
<form action="destroy" method="post">
    <input name="id" type="hidden" value="<?= $invoice->getId() ?>">
    <button class="red"><?= __('Delete') ?></button>
</form>
<?php } ?>

<?= component('layout.footer') ?>