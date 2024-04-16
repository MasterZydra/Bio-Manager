<?php

use Framework\Database\Migration\Migration;
use Framework\resources\Database\Seeders\UserSeeder;

return new class extends Migration
{
    public function run(): void
    {
        (new UserSeeder())->run();
    }
};
