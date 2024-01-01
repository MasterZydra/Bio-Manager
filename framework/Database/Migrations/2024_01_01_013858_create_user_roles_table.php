<?php

use Framework\Database\Database;
use Framework\Database\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Database::query(
            'CREATE TABLE userRoles (' .
            'id INT auto_increment,' .
            'userId INT NOT NULL,' .
            'roleId INT NOT NULL,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id),' .
            'CONSTRAINT `fkUserRolesUserId` FOREIGN KEY (userId) REFERENCES users (id) ON DELETE CASCADE,' .
            'CONSTRAINT `fkUserRolesRole` FOREIGN KEY (roleId) REFERENCES roles (id) ON DELETE CASCADE' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
