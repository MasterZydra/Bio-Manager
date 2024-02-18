<?php

namespace Framework\Database\Seeders;

use App\Models\Language;
use Framework\Database\Seeder;
use Framework\Database\SeederInterface;

class LanguageSeeder extends Seeder implements SeederInterface
{
    public function run(): void
    {
        (new Language())->setCode('de')->setName('German')->save();
        (new Language())->setCode('en')->setName('English')->save();
    }
}
