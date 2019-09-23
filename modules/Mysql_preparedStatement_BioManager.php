<?php
/*
* Mysql_preparedStatement_BioManger.php
* -------------------------------------
* Class for using prepared statments for a more secure way to
* execute sql queries and prevent sql injections.
* This class has functions which execute the queries for the
* Bio-Manager.
*
* @author David Hein
*
* Changelog:
* ----------
*/
include 'modules/Mysql_preparedStatement.php';

class mysql_preparedStatement_BioManager extends mysql_preparedStatement {
    /**
    * Create a new mysql_preparedStatement object.
    * Connect to database.
    */
    function __construct() {
        // Create parent
        parent::__construct();
    }

    /**
    * Select supplier with given id
    *
    * @param int    $supplierId Id of supplier whos data will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectSupplier($supplierId) {
        $sqlQuery = "SELECT * FROM T_Supplier WHERE id = ?";
        return $this -> selectWhereId($sqlQuery, $supplierId);
    }
    
    /**
    * Select setting with given id
    *
    * @param int    $settingId  Id of setting which data will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectSetting($settingId) {
        $sqlQuery = "SELECT * FROM T_Setting WHERE id = ?";
        return $this -> selectWhereId($sqlQuery, $settingId);
    }
    
    /**
    * Select recipient with given id
    *
    * @param int    $recipientId    Id of recipient whoes data will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectRecipient($recipientId) {
        $sqlQuery = "SELECT * FROM T_Recipient WHERE id = ?";
        return $this -> selectWhereId($sqlQuery, $recipientId);
    }
    
    /**
    * Select product with given id
    *
    * @param int    $productId  Id of product which data will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectProduct($productId) {
        $sqlQuery = "SELECT * FROM T_Product WHERE id = ?";
        return $this -> selectWhereId($sqlQuery, $productId);
    }

    /**
    * Select pricing with given id
    *
    * @param int    $pricingId  Id of pricing which data will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectPricing($pricingId) {
        $sqlQuery = "SELECT * FROM T_Pricing WHERE id = ?";
        return $this -> selectWhereId($sqlQuery, $pricingId);
    }
    
    /**
    * Select plot with given id
    *
    * @param int    $plotId Id of plot which data will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectPlot($plotId) {
        $sqlQuery = "SELECT * FROM T_Plot WHERE id = ?";
        return $this -> selectWhereId($sqlQuery, $plotId);
    }

    /**
    * Select invoice with given id
    *
    * @param int    $invoiceId  Id of invoice which data will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectInvoice($invoiceId) {
        $sqlQuery = "SELECT * FROM T_Invoice WHERE id = ?";
        return $this -> selectWhereId($sqlQuery, $invoiceId);
    }
    
    /**
    * Select delivery note with given id
    *
    * @param int    $deliveryNoteId Id of delivery note which data will be selected
    *
    * @author David Hein
    * @return mysqli_result/NULL
    */
    public function selectDeliveryNote($deliveryNoteId) {
        $sqlQuery = "SELECT * FROM T_DeliveryNote WHERE id = ?";
        return $this -> selectWhereId($sqlQuery, $deliveryNoteId);
    }
}

?>