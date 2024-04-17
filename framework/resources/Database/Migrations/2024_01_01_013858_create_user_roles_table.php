<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('userRoles'))
            ->id()
            ->int('userId', foreignKey: ['users' => 'id'])
            ->int('roleId', foreignKey: ['roles' => 'id'])
            ->timestamps()
        );
    }
};
