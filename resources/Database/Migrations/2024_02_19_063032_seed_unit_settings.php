<?php

use Framework\Database\Migration;
use Resources\Database\Seeders\UnitsSeeder;

return new class extends Migration
{
    public function run(): void
    {
        (new UnitsSeeder())->run();
    }
};
