<?php

use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::unprepared(
            'CREATE TABLE plots (' .
            'id INT auto_increment,' .
            'nr VARCHAR(30) NOT NULL,' .
            'name VARCHAR(100) NOT NULL,' .
            'subdistrict VARCHAR(50) NOT NULL,' .
            'supplierId INT NOT NULL,' .
            'isLocked tinyint(1) NOT NULL DEFAULT 0,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id),' .
            'CONSTRAINT `fkPlotSupplier` FOREIGN KEY (supplierId) REFERENCES suppliers (id) ON DELETE CASCADE' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
