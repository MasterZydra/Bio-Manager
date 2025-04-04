<?php

declare(strict_types = 1);

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('users'))
            ->id()
            ->string('firstname', 30)
            ->string('lastname', 30)
            ->string('username', 30, unique: true)
            ->string('password', 255)
            ->bool('isLocked')
            ->bool('isPwdChangeForced')
            ->int('languageId', nullable: true, foreignKey: ['languages' => 'id'])
            ->timestamps()
        );
    }
};
