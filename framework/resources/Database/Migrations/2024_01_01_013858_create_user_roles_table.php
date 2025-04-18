<?php

declare(strict_types = 1);

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        Database::executeBlueprint(new CreateTableBlueprint('userRoles')
            ->id()
            ->int('userId', foreignKey: ['users' => 'id'])
            ->int('roleId', foreignKey: ['roles' => 'id'])
            ->timestamps()
        );
    }
};
