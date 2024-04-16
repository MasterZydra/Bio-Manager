<?php

use Framework\Database\Database;
use Framework\Database\Migration\Migration;

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
            'languageId INT DEFAULT NULL,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id),' .
            'UNIQUE KEY `ukUsersUsername` (username),' .
            'CONSTRAINT `fkUserLanguageId` FOREIGN KEY (languageId) REFERENCES languages (id) ON DELETE CASCADE' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
