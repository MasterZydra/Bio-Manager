<?php
/*
* invoice.php
* -----------
* This file contains the class 'invoice'. It gets the invoice data e.g. from the
* setting table. This class can be used to get the data from the tables and use them
* in an invoice.
*
* @Author: David Hein
* 
* Changelog:
* ----------
* 28.08.2019:
*   - Remove default values and get values from setting table
*/

class invoice {
    // PDF Data
    public $pdfAuthor;
    public $pdfName;
    // Invoice meta data
    public $invoiceYear;
    public $invoiceNr;
    public $invoiceDate;
    // Sender and receiver
    public $invoiceSender;
    public $invoiceReceiver;
    // Banking data
    public $bankDetails_name;
    public $bankDetails_IBAN;
    public $bankDetails_BIC;
    // Product meta data
    public $volumeUnit;
    public $pricePerUnit;
    
    /**
    * Construct invoice object.
    * Get values from data base.
    *
    * @author David Hein
    */
    function __construct() {
        // PDF Data
        $this -> pdfName            = getSetting('invoiceName');
        $this -> pdfAuthor          = getSetting('invoiceAuthor');
        // Sender and receiver
        $this -> invoiceSender      = getSetting('invoiceSender');
        $this -> invoiceReceiver    = "";//getSetting('invoiceReceiver');
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
    
    /**
    * Build invoice name.
    *
    * @author David Hein
    * @return invoice name
    */
    function getInvoiceName() {
        return $this -> pdfName . '_' . (string)$this -> invoiceYear . '_' . (string)$this -> invoiceNr;
    }
}
?>