<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
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
