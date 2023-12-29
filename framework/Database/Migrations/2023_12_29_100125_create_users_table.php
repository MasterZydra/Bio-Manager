<?php

use Framework\Database\Database;
use Framework\Database\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Database::query(
            'CREATE TABLE users (' .
            'id INT auto_increment,' .
            'firstname VARCHAR(30) NOT NULL,' .
            'lastname VARCHAR(30) NOT NULL,' .
            'login VARCHAR(30) NOT NULL,' .
            'password VARCHAR(255) NULL,' .
            'forcePwdChange tinyint(1) NOT NULL,' .
            'PRIMARY KEY (id)' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
