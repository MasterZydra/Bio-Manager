<?php

use Framework\resources\Database\Seeders\ImprintSettingsSeeder;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        (new ImprintSettingsSeeder())->run();
    }
};
