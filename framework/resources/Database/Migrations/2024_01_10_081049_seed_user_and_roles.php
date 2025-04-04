<?php

use Framework\resources\Database\Seeders\UserSeeder;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        (new UserSeeder())->run();
    }
};
