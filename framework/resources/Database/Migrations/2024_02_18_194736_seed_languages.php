<?php

declare(strict_types = 1);

use Framework\resources\Database\Seeders\LanguageSeeder;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        (new LanguageSeeder())->run();
    }
};
