<?php

use Framework\resources\Database\Seeders\InvoiceSettingsSeeder;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        (new InvoiceSettingsSeeder())->run();
    }
};
