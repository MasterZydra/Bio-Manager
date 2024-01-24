<?php /** @var \App\Models\Invoice $invoice */ ?>
<?= component('layout.header') ?>

<h1><?= __('EditInvoice') ?></h1>

<p>
    <a href="/invoice"><?= __('ShowAllInvoices') ?></a>    
</p>

<form action="update" method="post">
    <input name="id" type="hidden" value="<?= $invoice->getId() ?>">

    <label for="year"><?= __('Year') ?>:</label><br>
    <input id="year" name="year" type="number" value="<?= $invoice->getYear() ?>" readonly><br>

    <label for="nr"><?= __('No.') ?>:</label><br>
    <input id="nr" name="nr" type="number" value="<?= $invoice->getNr() ?>" readonly><br>

    <label for="invoiceDate" class="required"><?= __('No.') ?>:</label><br>
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

    <button><?= __('Save') ?></button>
</form>

<form action="destroy" method="post">
    <input name="id" type="hidden" value="<?= $invoice->getId() ?>">
    <button class="red"><?= __('Delete') ?></button>
</form>

<?= component('layout.footer') ?>