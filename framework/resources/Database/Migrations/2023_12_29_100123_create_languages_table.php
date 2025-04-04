<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('languages'))
            ->id()
            ->string('code', 5, unique: true)
            ->string('name', 30)
            ->timestamps()
        );
    }
};
