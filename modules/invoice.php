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
        // Product meta data
        $this -> volumeUnit         = getSetting('volumeUnit');
        

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