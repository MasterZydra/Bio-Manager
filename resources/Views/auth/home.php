<?php use Framework\Authentication\Auth; ?>
<?= component('layout.header') ?>

<h1><?= __('WelcomeToMemberArea') ?></h1>

<h2><?= __('MySpace') ?></h2>

<div class="box">
    <strong><?= __('MyAccount') ?></strong><br>
    <a href="changePassword"><?= __('ChangePassword') ?></a><br>
    <a href="logout"><?= __('Logout') ?></a>
</div>

<?php
    // Links for suppliers
    if (Auth::hasRole('Supplier')) {
?>
<div class="box">
    <strong><?= __('MyData') ?></strong><br>
    <a href="showMyDeliveryNote.php"><?= __('MyDeliveryNotes') ?></a>
</div>
<?php } ?>

<?php
// Check configuration
// TOOD include 'Modules/configChecker.php';

// Links for maintainers
if (Auth::hasRole('Maintainer')) { ?>

<h2><?= __('DataManagement') ?></h2>

<div class="box">
    <strong><?= __('DeliveryNote') ?></strong><br>
    <a href="deliveryNote"><?= __('ShowAllDeliveryNotes') ?></a>
    <?php if (Auth::hasRole('Maintainer')) { ?>
        <br><a href="deliveryNote/create"><?= __('AddDeliveryNote') ?></a>
    <?php } ?>
</div>

<div class="box">
    <strong><?= __('Plot') ?></strong><br>
    <a href="plot"><?= __('ShowAllPlots') ?></a>
    <?php if (Auth::hasRole('Maintainer')) { ?>
        <br><a href="plot/create"><?= __('AddPlot') ?></a>
    <?php } ?>
</div>

<div class="box">
    <strong><?= __('Invoice') ?></strong><br>
    <a href="invoice"><?= __('ShowAllInvoices') ?></a>
    <?php if (Auth::hasRole('Maintainer')) { ?>
        <br><a href="invoice/create"><?= __('AddInvoice') ?></a>
    <?php } ?>
</div>

<div class="box">
    <strong><?= __('Product') ?></strong><br>
    <a href="product"><?= __('ShowAllProducts') ?></a>
    <?php if (Auth::hasRole('Maintainer')) { ?>
        <br><a href="product/create"><?= __('AddProduct') ?></a>
    <?php } ?>
</div>

<div class="box">
    <strong><?= __('Price') ?></strong><br>
    <a href="price"><?= __('ShowAllPrices') ?></a>
    <?php if (Auth::hasRole('Maintainer')) { ?>
        <br><a href="price/create"><?= __('AddPrice') ?></a>
    <?php } ?>
</div>

<div class="box">
    <strong><?= __('Supplier') ?></strong><br>
    <a href="supplier"><?= __('ShowAllSuppliers') ?></a>
    <?php if (Auth::hasRole('Maintainer')) { ?>
        <br><a href="supplier/create"><?= __('AddSupplier') ?></a>
    <?php } ?>
</div>

<div class="box">
    <strong><?= __('Recipient') ?></strong><br>
    <a href="recipient"><?= __('ShowAllRecipients') ?></a>
    <?php if (Auth::hasRole('Maintainer')) { ?>
        <br><a href="recipient/create"><?= __('AddRecipient') ?></a>
    <?php } ?>
</div>

<h2>
    Auswertungen
</h2>

<div class="box">
    <strong><?= __('Supplier') ?></strong><br>
    <a href="activeSuppiers" target="_blank"><?= __('ShowActiveSuppliers') ?></a><br>
    <a href="showSupplierPayments.php">Auszahlungen anzeigen</a><br>
</div>

<div class="box">
    <strong>Lieferschein</strong><br>
    <a href="showDeliveryNote_OpenVolumeDistribution.php">Offene Mengenverteilungen</a><br>
    <a href="showCropVolumeDistribution.php">Mengenverteilung anzeigen</a>
</div>

<?php }
// Links for administration
if (Auth::hasRole('Administrator')) { ?>

<h2><?= __('Administration') ?></h2>

<div class="box">
    <strong><?= __('UserManagement') ?></strong><br>
    <a href="user"><?= __('ShowAllUsers') ?></a><br>
    <a href="user/create"><?= __('AddUser') ?></a> 
</div>

<div class="box">
    <strong><?= __('Setting') ?></strong><br>
    <a href="setting"><?= __('ShowAllSettings') ?></a>
    <?php if (Auth::hasRole('Developer')) { ?>
        <br><a href="setting/create"><?= __('AddSetting') ?></a>
    <?php } ?>
</div>

<div class="box">
    <strong>Systemeinstellungen</strong><br>
    <a href="editImpressum.php">Impressum bearbeiten</a><br>
    <a href="editInvoiceData.php">Rechnungsdaten bearbeiten</a>
</div>

<div class="box">
    <strong>Grundeinstellungen</strong><br>
    <a href="editCommonConfig.php">Allgemeine Einstellungen</a><br>
    <a href="editDBConnection.php">Datenbankverbindung bearbeiten</a>
</div>

        <?php
    }
    if (Auth::hasRole('Developer')) {
        ?>
<h2>
    Entwickler
</h2>
        <?php
        // showWarning('<strong>Verwendung auf eigene Gefahr!</strong>');
        ?>
<div class="box">
    <a href="developerOptions.php">Entwicklereinstellungen</a>
</div>

<div class="box">
    <strong>Seiten in Entwicklung</strong><br>
    Keine Seiten in Entwicklung...
</div>

        <?php
    }
?>
<script>
    function colorBoxes() {
        var colors = ['#0E161C', '#3F4045', '#153D6B', '#145C9E', '#11626D', '#2A4D14', '#4a8a16', '#E26D00'];
        $boxes = document.getElementsByClassName('box');
        for(var i = 0; i < $boxes.length; i++) {
            $boxes[i].setAttribute('style', 'background-color: ' + colors[i % colors.length] + ';');
        }
    }
    colorBoxes();
</script>

<?= component('layout.footer') ?>