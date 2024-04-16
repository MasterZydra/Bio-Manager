<?php

use Framework\Database\Migration\Migration;
use Framework\Database\Seeders\ImprintSettingsSeeder;

return new class extends Migration
{
    public function run(): void
    {
        (new ImprintSettingsSeeder())->run();
    }
};
