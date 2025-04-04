<?php

declare(strict_types = 1);

namespace Framework\resources\Database\Seeders;

use App\Models\Language;
use Framework\Database\Seeder\Seeder;
use Framework\Database\Seeder\SeederInterface;

class LanguageSeeder extends Seeder implements SeederInterface
{
    public function run(): void
    {
        (new Language())->setCode('de')->setName('German')->save();
        (new Language())->setCode('en')->setName('English')->save();
    }
}
