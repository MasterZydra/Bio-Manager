<?php

use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::unprepared(
            'CREATE TABLE deliveryNotes (' .
            'id INT auto_increment,' .
            '`year` INT NOT NULL,' .
            'nr INT NOT NULL,' .
            'deliveryDate DATE DEFAULT NULL,' .
            'amount FLOAT DEFAULT NULL,' .
            'productId INT NOT NULL,' .
            'supplierId INT NOT NULL,' .
            'recipientId INT NOT NULL,' .
            'isInvoiceReady tinyint(1) NOT NULL DEFAULT 0,' .
            'invoiceId INT DEFAULT NULL,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id),' .
            'CONSTRAINT `fkDeliveryNoteProduct` FOREIGN KEY (productId) REFERENCES products (id) ON DELETE CASCADE,' .
            'CONSTRAINT `fkDeliveryNoteSupplier` FOREIGN KEY (supplierId) REFERENCES suppliers (id) ON DELETE CASCADE,' .
            'CONSTRAINT `fkDeliveryNoteRecipient` FOREIGN KEY (recipientId) REFERENCES recipients (id) ON DELETE CASCADE,' .
            'CONSTRAINT `fkDeliveryNoteInvoice` FOREIGN KEY (invoiceId) REFERENCES invoices (id) ON DELETE SET NULL' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};