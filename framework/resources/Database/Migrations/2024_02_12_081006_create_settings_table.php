<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('settings'))
            ->id()
            ->string('name', 100, unique: true)
            ->string('description', 255)
            ->string('value', 255)
            ->timestamps()
        );
    }
};