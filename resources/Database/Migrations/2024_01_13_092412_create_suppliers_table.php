<?php

declare(strict_types = 1);

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        Database::executeBlueprint(new CreateTableBlueprint('suppliers')
            ->id()
            ->string('name', 50, unique: true)
            ->bool('isLocked')
            ->bool('hasFullPayout')
            ->bool('hasNoPayout')
            ->timestamps()
        );
    }
};
