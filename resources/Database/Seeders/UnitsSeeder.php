<?php

namespace Resources\Database\Seeders;

use App\Models\Setting;
use Framework\Database\Seeder;
use Framework\Database\SeederInterface;

class UnitsSeeder extends Seeder implements SeederInterface
{
    public function run(): void
    {
        (new Setting())
            ->setName('massUnit')
            ->setDescription('Mass unit')
            ->setValue('kg')
            ->save();
    }
}
