<?php

// https://www.php-einfach.de/experte/php-codebeispiele/pdf-per-php-erstellen-pdf-rechnung/

class invoice {
    // PDF Data
    public $pdfAuthor;
    public $pdfName;
    // Meta data
    public $invoiceYear;
    public $invoiceNr;
    public $invoiceDate;
    public $invoiceSender;
    public $invoiceReceiver;
    
    public $volumeUnit;
    public $pricePerUnit;

    public $bankDetails_name;
    public $bankDetails_IBAN;
    public $bankDetails_BIC;
    
    function __construct() {
        // PDF Data
        $this -> pdfName            = getSetting('invoiceName');
        $this -> pdfAuthor          = getSetting('invoiceAuthor');
        // Sender and receiver
        $this -> invoiceSender      = getSetting('invoiceSender');
        $this -> invoiceReceiver    = getSetting('invoiceReceiver');
        // Banking data
        $this -> bankDetails_name   = getSetting('invoiceBankName');
        $this -> bankDetails_IBAN   = getSetting('invoiceIBAN');
        $this -> bankDetails_BIC    = getSetting('invoiceBIC');
        // Product meta data
        $this -> volumeUnit         = getSetting('volumeUnit');
        
        // Invoice meta data
        $this -> invoiceYear = 2019;
        $this -> invoiceNr = 1;
        $this -> invoiceDate = date("d.m.Y");
        
        $this -> pricePerUnit = '1';
    }
    
    function getInvoiceName() {
        return $this -> pdfName . '_' . (string)$this -> invoiceYear . '_' . (string)$this -> invoiceNr;
    }
}
?>