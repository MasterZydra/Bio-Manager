<?php

use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::unprepared(
            'CREATE TABLE invoices (' .
            'id INT auto_increment,' .
            '`year` INT NOT NULL,' .
            'nr INT NOT NULL,' .
            'invoiceDate DATE DEFAULT NULL,' .
            'recipientId INT NOT NULL,' .
            'isPaid tinyint(1) NOT NULL DEFAULT 0,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id),' .
            'CONSTRAINT `fkInvoiceRecipient` FOREIGN KEY (recipientId) REFERENCES recipients (id) ON DELETE CASCADE' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
