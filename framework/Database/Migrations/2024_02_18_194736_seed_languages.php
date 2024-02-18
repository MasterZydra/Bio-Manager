<?php

use Framework\Database\Migration;
use Framework\Database\Seeders\LanguageSeeder;

return new class extends Migration
{
    public function run(): void
    {
        (new LanguageSeeder())->run();
    }
};
