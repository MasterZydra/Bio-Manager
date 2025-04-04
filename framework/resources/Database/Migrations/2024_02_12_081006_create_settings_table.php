<?php

declare(strict_types = 1);

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;

return new class extends \Framework\Database\Migration\Migration
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