<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        $table = new CreateTableBlueprint('migrations');
        $table->id();
        $table->string('name', 255);
        $table->timestamps();
        
        Database::unprepared(
            $table->build() .
            'CREATE TABLE migrations (' .
            'id INT auto_increment,' .
            'name VARCHAR(255) NOT NULL,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id)' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
