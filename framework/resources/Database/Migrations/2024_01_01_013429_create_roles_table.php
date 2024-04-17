<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('roles'))
            ->id()
            ->string('name', 30, unique: true)
            ->timestamps()
        );
    }
};
