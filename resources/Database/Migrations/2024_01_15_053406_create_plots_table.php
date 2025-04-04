<?php

declare(strict_types = 1);

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('plots'))
            ->id()
            ->string('nr', 30)
            ->string('name', 100)
            ->string('subdistrict', 50)
            ->int('supplierId', foreignKey: ['suppliers' => 'id'])
            ->bool('isLocked')
            ->timestamps()
        );
    }
};
