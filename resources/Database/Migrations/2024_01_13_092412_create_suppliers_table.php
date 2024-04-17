<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('suppliers'))
            ->id()
            ->string('name', 50, unique: true)
            ->bool('isLocked')
            ->bool('hasFullPayout')
            ->bool('hasNoPayout')
            ->timestamps()
        );
    }
};
