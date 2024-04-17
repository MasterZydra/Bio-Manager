<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('products'))
            ->id()
            ->string('name', 50, unique: true)
            ->bool('isDiscontinued')
            ->timestamps()
        );
    }
};
