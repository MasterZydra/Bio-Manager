<?php

use Framework\Database\Database;
use Framework\Database\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Database::query(
            'CREATE TABLE migrations (' .
            'id INT auto_increment,' .
            'name VARCHAR(255) NOT NULL,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id)' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
