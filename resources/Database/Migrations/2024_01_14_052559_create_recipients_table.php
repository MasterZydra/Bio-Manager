<?php

declare(strict_types = 1);

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        Database::executeBlueprint(new CreateTableBlueprint('recipients')
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
