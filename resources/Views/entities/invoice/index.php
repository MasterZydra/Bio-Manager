<?php
    use Framework\Authentication\Auth;
    use Framework\Facades\Convert;
?>
<?= component('layout.header') ?>

<h1><?= __('Invoice') ?></h1>

<p>
    <?php if (Auth::hasRole('Maintainer')) {
        ?><a href="invoice/create"><?= __('AddInvoice') ?></a><?php
    } ?>
</p>

<?= component('filterInput') ?>

<table id="dataTable">
    <tr>
        <th class="center"><?= __('Year') ?></th>
        <th class="center"><?= __('No.') ?></th>
        <th class="center"><?= __('Date') ?></th>
        <th class="center"><?= __('Recipient') ?></th>
        <th class="center"><?= __('IsPaid') ?></th>
        <th class="center"><?= __('Actions') ?></th>
    </tr>
    <?php /** @var \App\Models\Invoice $invoice */
    foreach ($invoices as $invoice): ?>
    <tr>
        <td class="center"><?= $invoice->getYear() ?></td>
        <td class="center"><?= $invoice->getNr() ?></td>
        <td class="center"><?= $invoice->getInvoiceDate() ?></td>
        <td><?= $invoice->getRecipient()->getName() ?></td>
        <td class="center"><?= Convert::boolToTString($invoice->getIsPaid()) ?></td>
        <td><a href="invoice/edit?id=<?= $invoice->getId() ?>"><?=__('Edit') ?></a></td>
    </tr>
    <?php endforeach ?>
</table>

<?= component('layout.footer') ?>