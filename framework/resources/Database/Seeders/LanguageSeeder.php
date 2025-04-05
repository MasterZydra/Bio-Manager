<?php

declare(strict_types = 1);

namespace Framework\resources\Database\Seeders;

use App\Models\Language;

class LanguageSeeder extends \Framework\Database\Seeder\Seeder implements \Framework\Database\Seeder\SeederInterface
{
    public function run(): void
    {
        new Language()->setCode('de')->setName('German')->save();
        new Language()->setCode('en')->setName('English')->save();
    }
}
