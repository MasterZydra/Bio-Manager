<?php

use Framework\Database\Database;
use Framework\Database\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::unprepared(
            'CREATE TABLE suppliers (' .
            'id INT auto_increment,' .
            'name VARCHAR(50) NOT NULL,' .
            'isLocked tinyint(1) NOT NULL DEFAULT 0,' .
            'hasFullPayout tinyint(1) NOT NULL DEFAULT 0,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id),' .
            'UNIQUE KEY `ukSupplierName` (name)' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
