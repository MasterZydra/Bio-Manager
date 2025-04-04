<?php

use Resources\Database\Seeders\UnitsSeeder;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        (new UnitsSeeder())->run();
    }
};
