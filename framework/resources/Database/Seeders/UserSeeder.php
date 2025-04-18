<?php

declare(strict_types = 1);

namespace Framework\resources\Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Framework\Database\Database;

class UserSeeder extends \Framework\Database\Seeder\Seeder implements \Framework\Database\Seeder\SeederInterface
{
    public function run(): void
    {
        Database::unprepared('DELETE FROM userRoles WHERE 1=1;');
        Database::unprepared('DELETE FROM roles WHERE 1=1;');
        Database::unprepared('DELETE FROM users WHERE 1=1;');

        new Role()->setName('Developer')->save();
        new Role()->setName('Administrator')->save();
        new Role()->setName('Maintainer')->save();
        new Role()->setName('Supplier')->save();

        new User()
            ->setFirstname('Admin')->setLastname('Admin')
            ->setUsername('admin')->setPassword('mySecurePassword1!')
            ->setIsLocked(false)->setIsPwdChangeForced(false)
            ->save();

        new UserRole()
            ->setUserId(User::findByUsername('admin')->getId())
            ->setRoleId(Role::findByName('Administrator')->getId())
            ->save();
    }
};
