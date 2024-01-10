<?php

use Framework\Database\Migration;
use Framework\Database\Seeders\UserSeeder;

return new class extends Migration
{
    public function run(): void
    {
        (new UserSeeder())->run();
    }
};
