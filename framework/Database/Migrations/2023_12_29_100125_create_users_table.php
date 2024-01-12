<?php

use Framework\Database\Database;
use Framework\Database\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::unprepared(
            'CREATE TABLE users (' .
            'id INT auto_increment,' .
            'firstname VARCHAR(30) NOT NULL,' .
            'lastname VARCHAR(30) NOT NULL,' .
            'username VARCHAR(30) NOT NULL,' .
            'password VARCHAR(255) NULL,' .
            'isLocked tinyint(1) NOT NULL DEFAULT 0,' .
            'isPwdChangeForced tinyint(1) NOT NULL DEFAULT 0,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id),' .
            'UNIQUE KEY `ukUsersUsername` (username)' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
