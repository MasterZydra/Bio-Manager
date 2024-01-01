<?php

use Framework\Database\Database;
use Framework\Database\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Database::query(
            'CREATE TABLE products (' .
            'id INT auto_increment,' .
            'name VARCHAR(50) NOT NULL,' .
            'isDiscontinued tinyint(1) NOT NULL DEFAULT 0,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id),' .
            'UNIQUE KEY `ukProductName` (name)' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
