<?php

use Framework\Database\Database;
use Framework\Database\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::unprepared(
            'CREATE TABLE recipients (' .
            'id INT auto_increment,' .
            'name VARCHAR(100) NOT NULL,' .
            'street VARCHAR(255) NOT NULL,' .
            'postalCode VARCHAR(10) NOT NULL,' .
            'city VARCHAR(255) NOT NULL,' .
            'isLocked tinyint(1) NOT NULL DEFAULT 0,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id),' .
            'UNIQUE KEY `ukRecipientName` (name)' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
