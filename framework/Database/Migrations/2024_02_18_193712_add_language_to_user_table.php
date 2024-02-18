<?php

use Framework\Database\Database;
use Framework\Database\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::unprepared(
            'ALTER TABLE users ' .
            'ADD languageId INT DEFAULT NULL;'
        );

        Database::unprepared(
            'ALTER TABLE users ' .
            'ADD CONSTRAINT `fkUserLanguageId` FOREIGN KEY (languageId) REFERENCES languages (id) ON DELETE CASCADE;'
        );
    }
};
