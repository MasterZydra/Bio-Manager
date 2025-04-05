<?php

declare(strict_types = 1);

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        new \Framework\resources\Database\Seeders\ImprintSettingsSeeder()->run();
    }
};
