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
    // if (Auth::hasRole('Supplier')) {
 ?>
<!-- <div class="box">
    <strong><= __('MyData') ?></strong><br>
    <a href="showMyDeliveryNote"><= __('MyDeliveryNotes') ?></a>
</div> -->
<?php // }

// Links for maintainers
if (Auth::hasRole('Maintainer')) { ?>

<h2><?= __('DataManagement') ?></h2>

<div class="box">
    <strong><?= __('DeliveryNote') ?></strong><br>
    <a href="deliveryNote"><?= __('ShowAllDeliveryNotes') ?></a><br>
    <a href="deliveryNote/create"><?= __('AddDeliveryNote') ?></a>
</div>

<div class="box">
    <strong><?= __('Plot') ?></strong><br>
    <a href="plot"><?= __('ShowAllPlots') ?></a><br>
    <a href="plot/create"><?= __('AddPlot') ?></a>
</div>

<div class="box">
    <strong><?= __('Invoice') ?></strong><br>
    <a href="invoice"><?= __('ShowAllInvoices') ?></a><br>
    <a href="invoice/create"><?= __('AddInvoice') ?></a>
</div>

<div class="box">
    <strong><?= __('Product') ?></strong><br>
    <a href="product"><?= __('ShowAllProducts') ?></a><br>
    <a href="product/create"><?= __('AddProduct') ?></a>
</div>

<div class="box">
    <strong><?= __('Price') ?></strong><br>
    <a href="price"><?= __('ShowAllPrices') ?></a><br>
    <a href="price/create"><?= __('AddPrice') ?></a>
</div>

<div class="box">
    <strong><?= __('Supplier') ?></strong><br>
    <a href="supplier"><?= __('ShowAllSuppliers') ?></a><br>
    <a href="supplier/create"><?= __('AddSupplier') ?></a>
</div>

<div class="box">
    <strong><?= __('Recipient') ?></strong><br>
    <a href="recipient"><?= __('ShowAllRecipients') ?></a><br>
    <a href="recipient/create"><?= __('AddRecipient') ?></a>
</div>

<h2><?= __('Analyses') ?></h2>

<div class="box">
    <strong><?= __('Supplier') ?></strong><br>
    <a href="activeSuppiers" target="_blank"><?= __('ShowActiveSuppliers') ?></a><br>
    <a href="showSupplierPayouts"><?= __('ShowPayouts') ?></a><br>
</div>

<div class="box">
    <strong><?= __('DeliveryNote') ?></strong><br>
    <a href="openVolumeDistributions"><?= __('OpenVolumeDistributions') ?></a><br>
    <a href="showVolumeDistribution"><?= __('ShowVolumeDistribution') ?></a><br>
    <a href="amountDevelopmentStats"><?= __('AmountDevelopment') ?></a>
</div>

<div class="box">
    <strong><?= __('Finances') ?></strong><br>
    <a href="financialRevenueProfitStats"><?= __('RevenueAndProfit') ?></a><br>
    <a href="priceDevelopmentStats"><?= __('PriceDevelopment') ?></a>
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
    <strong><?= __('SystemSettings') ?></strong><br>
    <a href="editImprintSettings"><?= __('EditImprint') ?></a><br>
    <a href="editInvoiceSettings"><?= __('EditInvoiceData') ?></a>
</div>

<div class="box">
    <strong><?= __('Setting') ?></strong><br>
    <a href="setting"><?= __('ShowAllSettings') ?></a><br>
    <a href="setting/create"><?= __('AddSetting') ?></a>
</div>

<?php }
// Links for developers
if (Auth::hasRole('Developer')) { ?>

<h2><?= __('Developer') ?></h2>

<div class="box">
    <a href="devTools"><?= __('Tools') ?></a><br>
    <a href="cli">CLI</a>
</div>

<?php } ?>

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