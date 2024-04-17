<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('recipients'))
            ->id()
            ->string('name', 100, unique: true)
            ->string('street', 255)
            ->string('postalCode', 10)
            ->string('city', 255)
            ->bool('isLocked')
            ->timestamps()
        );
    }
};
