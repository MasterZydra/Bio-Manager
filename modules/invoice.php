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
        $this -> pdfName = 'Invoice';
        $this -> pdfAuthor = 'Max Musterman';
        // Meta data
        $this -> invoiceYear = 2019;
        $this -> invoiceNr = 1;
        $this -> invoiceDate = date("d.m.Y");
        $this -> invoiceSender = 'Max Musterman
            Musterstraße 1
            12345 Musterstadt';
        $this -> invoiceReceiver = 'Moritz Musterman
            Musterstraße 2
            12345 Musterstadt';
        
        $this -> volumeUnit = 'kg';
        $this -> pricePerUnit = '1';
        $this -> bankDetails_name = 'Bank name';
        $this -> bankDetails_IBAN = 'DE123 4567';
        $this -> bankDetails_BIC = 'GEASDFG';
    }
    
    function getInvoiceName() {
        return $this -> pdfName . '_' . (string)$this -> invoiceYear . '_' . (string)$this -> invoiceNr;
    }
}
?>