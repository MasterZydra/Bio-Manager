<?php

use Framework\Database\Database;
use Framework\Database\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::unprepared(
            'CREATE TABLE prices (' .
            'id INT auto_increment,' .
            '`year` INT NOT NULL,' .
            'price float NOT NULL,' .
            'pricePayout float NOT NULL,' .
            'productId INT NOT NULL,' .
            'recipientId INT NOT NULL,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id),' .
            'CONSTRAINT `fkPriceProduct` FOREIGN KEY (productId) REFERENCES products (id) ON DELETE CASCADE,' .
            'CONSTRAINT `fkPriceRecipient` FOREIGN KEY (recipientId) REFERENCES recipients (id) ON DELETE CASCADE' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
