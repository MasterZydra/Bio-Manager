<?php

use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::unprepared(
            'CREATE TABLE volumeDistributions (' .
            'id INT auto_increment,' .
            'deliveryNoteId INT NOT NULL,' .
            'plotId INT NOT NULL,' .
            'amount FLOAT DEFAULT NULL,' .
            'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,' .
            'updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,' .
            'PRIMARY KEY (id),' .
            'CONSTRAINT `fkVolDistDeliveryNote` FOREIGN KEY (deliveryNoteId) REFERENCES deliveryNotes (id) ON DELETE CASCADE,' .
            'CONSTRAINT `fkVolDistPlot` FOREIGN KEY (plotId) REFERENCES plots (id) ON DELETE CASCADE' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }
};
