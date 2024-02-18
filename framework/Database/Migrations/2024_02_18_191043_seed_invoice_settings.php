<?php

use Framework\Database\Migration;
use Framework\Database\Seeders\InvoiceSettingsSeeder;

return new class extends Migration
{
    public function run(): void
    {
        (new InvoiceSettingsSeeder())->run();
    }
};
