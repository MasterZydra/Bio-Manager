<?= component('layout.header') ?>

<h1><?= __('EditInvoiceData') ?></h1>

<form method="post">
    <h2><?= __('Sender') ?></h2>

    <label for="invoiceSenderName" class="required"><?= __('Name') ?>:</label><br>
    <input id="invoiceSenderName" name="invoiceSenderName" type="text" value="<?= setting('invoiceSenderName') ?>" autofocus required><br>

    <label for="invoiceSenderStreet" class="required"><?= __('Street') ?>:</label><br>
    <input id="invoiceSenderStreet" name="invoiceSenderStreet" type="text" value="<?= setting('invoiceSenderStreet') ?>" required><br>

    <label for="invoiceSenderPostalCode" class="required"><?= __('PostalCode') ?>:</label><br>
    <input id="invoiceSenderPostalCode" name="invoiceSenderPostalCode" type="text" value="<?= setting('invoiceSenderPostalCode') ?>" required><br>

    <label for="invoiceSenderCity" class="required"><?= __('City') ?>:</label><br>
    <input id="invoiceSenderCity" name="invoiceSenderCity" type="text" value="<?= setting('invoiceSenderCity') ?>" required><br>

    <label for="invoiceSenderAddition"><?= __('Addition') ?>:</label><br>
    <input id="invoiceSenderAddition" name="invoiceSenderAddition" type="text" value="<?= setting('invoiceSenderAddition') ?>"><br>

    <h2><?= __('Bank') ?></h2>

    <label for="invoiceBankName" class="required"><?= __('Name') ?>:</label><br>
    <input id="invoiceBankName" name="invoiceBankName" type="text" value="<?= setting('invoiceBankName') ?>" required><br>

    <label for="invoiceIBAN" class="required"><?= __('IBAN') ?>:</label><br>
    <input id="invoiceIBAN" name="invoiceIBAN" type="text" value="<?= setting('invoiceIBAN') ?>" onchange="validateIbanInput()" required><br>
    <div style="margin-bottom: 8px;"><span id="ibanValidMsg"></span></div>

    <label for="invoiceBIC" class="required"><?= __('BIC') ?>:</label><br>
    <input id="invoiceBIC" name="invoiceBIC" type="text" value="<?= setting('invoiceBIC') ?>" required><br>

    <h2><?= __('Miscellaneous') ?></h2>

    <label for="invoiceAuthor" class="required"><?= __('Author') ?>:</label><br>
    <input id="invoiceAuthor" name="invoiceAuthor" type="text" value="<?= setting('invoiceAuthor') ?>" required><br>

    <label for="invoiceName" class="required"><?= __('InvoiceName') ?>:</label><br>
    <input id="invoiceName" name="invoiceName" type="text" value="<?= setting('invoiceName') ?>" required><br>

    <button><?= __('Save') ?></button>
</form>

<script src="js/validateIBAN.js"></script>
<script>

function validateIbanInput()
{
    let msgSpan = document.getElementById('ibanValidMsg');
    if (validateIBAN(document.getElementById('invoiceIBAN').value)) {
        console.log("yes");
        msgSpan.style = 'color: #4a8a16;';
        msgSpan.textContent = '<?= __('IbanIsValid') ?>';
    } else {
        console.log("no");
        msgSpan.style = 'color: #b01c1c;';
        msgSpan.textContent = '<?= __('IbanIsNotValid') ?>';
    }
}

validateIbanInput();
</script>

<?= component('layout.footer') ?>